using Helper;
using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;

namespace CrawlerForWp
{
    public static class HandleHtml
    {

        /// <summary>
        /// 获取html
        /// </summary>
        /// <param name="cof">请求配置baseUrl，page，</param>
        /// <returns></returns>
        public static StringBuilder GetHtml(Dictionary<string, string> cof)
        {
            if (cof == null)
            {
                return null;

            }
            if (cof["baseUrl"] != null && cof["baseUrl"].IndexOf("?") <= 0)
            {
                cof["baseUrl"] = (cof["baseUrl"] + "?");
            }
            HttpItem item = new HttpItem();
            HttpHelper httpHelper = new HttpHelper();
            item.URL = cof["baseUrl"];
            cof.Remove("baseUrl");
            item.URL += "&" + string.Join("&", cof.Values);
            StringBuilder sb = new StringBuilder();
            try
            {
                sb.Clear();
                sb.Append(httpHelper.GetHtml(item).Html);
                StrReplace(ref sb);
                return sb;
            }
            catch (Exception)
            {
                sb.Clear();
                return sb;

            }
        }
        /// <summary>
        /// 获取爬虫基础配置
        /// </summary>
        /// <param name="cId"></param>
        /// <returns></returns>
        public static Dictionary<string, string> GetCralerCof(int cId)
        {
            Dictionary<string, string> cof = new Dictionary<string, string>();
            crawler_config cCof = crawler_configDAL.GetById(cId);
            if (cCof == null)
            {
                return null;
            }
            cof.Add("baseUrl", cCof.SubmitUrl);
            cof.Add("page", cCof.PageField);
            cof.Add("key", cCof.KeyWordField);
            return cof;
        }

        /// <summary>
        /// 组装配置
        /// </summary>
        /// <param name="cof"></param>
        /// <param name="page"></param>
        /// <param name="keyword"></param>
        /// <returns></returns>
        public static Dictionary<string, string> PackageCof(Dictionary<string, string> cof, string page, string keyword)
        {
            if (cof == null)
            {
                return cof;
            }
            Dictionary<string, string> c = new Dictionary<string, string>();
            c.Clear();
            c["page"] = cof["page"] + "=" + page;
            c["key"] = cof["key"] + "=" + (keyword);
            c["baseUrl"] = cof["baseUrl"];
            return c;
        }
        /// <summary>
        /// 移除换行 空格
        /// </summary>
        /// <param name="sb"></param>
        public static void StrReplace(ref StringBuilder sb)
        {
            sb.Replace(" ", "").Replace("\t", "").Replace("\n", "").Replace("\r", "").Replace("<fontstyle='color:red'>", "").Replace("</font>", "");
        }
        /// <summary>
        /// 移除html标记
        /// </summary>
        /// <param name="stringToStrip"></param>
        /// <param name="newstr"></param>
        /// <returns></returns>
        public static string StrReplaceHtml(string stringToStrip, string newstr = "  ")
        {
            stringToStrip = Regex.Replace(stringToStrip, "</p(?:\\s*)>(?:\\s*)<p(?:\\s*)>", "\n\n", RegexOptions.IgnoreCase | RegexOptions.Compiled);
            stringToStrip = Regex.Replace(stringToStrip, "<[^>]+>", newstr, RegexOptions.IgnoreCase | RegexOptions.Compiled);
            return stringToStrip;
        }
        /// <summary>
        /// 添加日志
        /// </summary>
        /// <param name="content"></param>
        /// <param name="type"></param>
        public static void AddLog(string content, int type = 1)
        {
            log model = new log();
            model.AddTime = DateToUnixTimeStamp(DateTime.Now);
            model.Contents = content;
            model.Type = type.ToString();
            logDAL.Insert(model);
        }

        /// <summary>
        /// 时间戳转为C#格式时间
        /// </summary>
        /// <param name="timeStamp">Unix时间戳格式</param>
        /// <returns>C#格式时间</returns>
        public static DateTime UnixTimeStampToDate(string timeStamp)
        {
            DateTime dtStart = TimeZone.CurrentTimeZone.ToLocalTime(new DateTime(1970, 1, 1));
            long lTime = long.Parse(timeStamp + "0000000");
            TimeSpan toNow = new TimeSpan(lTime);
            return dtStart.Add(toNow);
        }
        /// <summary>
        /// Date转时间戳
        /// </summary>
        /// <param name="time"></param>
        /// <returns></returns>
        public static int DateToUnixTimeStamp(System.DateTime time)
        {
            System.DateTime startTime = TimeZone.CurrentTimeZone.ToLocalTime(new System.DateTime(1970, 1, 1));
            return (int)(time - startTime).TotalSeconds;
        }
        /// <summary>
        /// 更新事务
        /// </summary>
        /// <param name="taskModel"></param>
        /// <param name="Note"></param>
        /// <param name="Status"></param>
        public static void UpdateTask(crawler_task taskModel, string Note, int Status)
        {
            taskModel.Status = Status;
            taskModel.Note = Note;
            taskModel.UpdateTime = DateToUnixTimeStamp(DateTime.Now);
            crawler_taskDAL.Update(taskModel);
        }
        /// <summary>
        /// 执行事务
        /// </summary>
        /// <param name="taskModel"></param>
        public static void ExecuteTask(crawler_task taskModel)
        {
            int stopCount = 0, //停止阀值
                completeCount = 0,//已完成记录
                allCount = 0;//搜索总记录
            //基础配置字典
            Dictionary<string, string> cof = HandleHtml.GetCralerCof(taskModel.ConfigId);
            //搜索字典
            Dictionary<string, string> cofSera = new Dictionary<string, string>();
            crawler_config cofModel = crawler_configDAL.GetById(taskModel.ConfigId);
            if (cofModel == null || cofModel.TableName.Trim().Equals(""))
            {
                HandleHtml.AddLog("没有找到搜索所对应的正则配置；任务：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
                UpdateTask(taskModel, "没有找到搜索所对应的正则配置", 11);
                return;
            }
            cofModel.StopPageCount = cofModel.StopPageCount <= 0 ? 3 : cofModel.StopPageCount;
            //字段名
            List<string> lsTbCols = cofModel.Fields.Split('|').ToList();
           // lsTbCols = lsTbCols.OrderBy(a => a).ToList();
            //正则配置｛每个字段对应一个｝
            List<crawler_regex> lsRegex = crawler_regexDAL.ListByWhere(new crawler_regex() { ConfigId = taskModel.ConfigId }, "", "ConfigId").ToList();
            if (lsRegex == null || lsRegex.Count <= 0)
            {
                HandleHtml.AddLog("没有找到搜索所对应的正则配置；任务：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
                UpdateTask(taskModel, "没有找到搜索所对应的正则配置", 11);
                return;
            }
           // lsRegex = lsRegex.OrderBy(a => a.ColName).ToList();
            //sql
            string sql = "INSERT INTO `" + cofModel.TableName.Trim() + "`(`" + string.Join("`, `", lsTbCols) + "`,`SYS_AddTime`)VALUES(@" + string.Join(", @", lsTbCols) + ",@SYS_AddTime);";
            //正则
            //所有记录
            Regex allRowRegex = new Regex(cofModel.AllRowConfig, RegexOptions.IgnoreCase | RegexOptions.Compiled | RegexOptions.Singleline);
            AddLog("搜索任务开始：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
            for (int p = 1; p <= cofModel.MaxPage; p++)
            {
                if (stopCount >= cofModel.StopPageCount || completeCount >= taskModel.SingleCount)
                {
                    break;
                }
                cofSera = HandleHtml.PackageCof(cof, p.ToString(), taskModel.KeyWords);
                StringBuilder sb = HandleHtml.GetHtml(cofSera);
                string res = (sb == null) ? "" : sb.ToString();
                try
                {
                    //匹配一页所有记录
                    MatchCollection mcls = allRowRegex.Matches(res);
                    List<MySqlParameter> lsParam = new List<MySqlParameter>();
                    for (int i = 0, c = mcls.Count; i < c; i++)
                    {
                        allCount++;
                        //单条记录处理
                        if (!mcls[i].Success)
                        {
                            continue;
                        }
                        lsParam.Clear();
                        string exSql = null;
                        bool isok = true;
                        foreach (var item in lsTbCols)
                        {
                            crawler_regex craRegex = lsRegex.Find(a => a.ColName == item) as crawler_regex;
                            craRegex = craRegex == null ? (new crawler_regex()
                            {
                                DefaultValue = "",
                                Suffix = "",
                                Prdfix = "",
                                Regex = null
                            }) : craRegex;
                            craRegex.DefaultValue = craRegex.DefaultValue == null || craRegex.DefaultValue.Equals("") ? "暂无" : craRegex.DefaultValue;
                            string v = craRegex.DefaultValue;
                            if (craRegex != null && craRegex.Regex != null && !craRegex.Regex.Equals(""))
                            {
                                Regex reCol = new Regex(craRegex.Regex, RegexOptions.IgnoreCase | RegexOptions.Compiled);
                                Match mCol = reCol.Match(mcls[i].Value);
                                v = mCol.Success ? mCol.Groups[item].Value : craRegex.DefaultValue;
                                if (mCol.Success)
                                {
                                    v = craRegex.Prdfix + mCol.Groups[item].Value + craRegex.Suffix;
                                }
                            }
                            v = HandleHtml.StrReplaceHtml(v).Replace("</", "");
                            if (exSql == null)
                            {
                                exSql = "SELECT * FROM `" + cofModel.TableName + "` WHERE `" + item + "`=@" + item + ";";
                                if (Helper.MySqlHelper.ExecuteScalar(exSql, new MySqlParameter("@" + item, v)) != null)
                                {
                                    isok = false;
                                    break;
                                }
                            }
                            lsParam.Add(new MySqlParameter("@" + item, v));
                        }
                        if (!isok)
                        {
                            continue;
                        }
                        lsParam.Add(new MySqlParameter("@SYS_AddTime", DateToUnixTimeStamp(DateTime.Now)));
                        if (Helper.MySqlHelper.ExecuteNonQuery(sql, lsParam.ToArray()) > 0)
                        {
                            completeCount++;
                        }
                    }
                }
                catch (Exception ex)
                {
                    HandleHtml.AddLog("系统异常：" + ex.Message);
                    stopCount++;
                }
            }
            UpdateTask(taskModel, "", 12);
            AddLog("搜索任务完毕：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
        }
    }
}
