using Helper;
using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;

namespace CrawlerForWp
{
    public static class CrawlerMD
    {

        /// <summary>
        /// 获取html
        /// </summary>
        /// <param name="cof">请求配置baseUrl，page，</param>
        /// <returns></returns>
        public static StringBuilder GetHtml(Dictionary<string, string> cof)
        {
            Form1.isbegin = true;
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
                Form1.isbegin = true;
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
        /// 更新系统配置
        /// </summary>
        /// <param name="AddSeaC"></param>
        /// <param name="AddCount"></param>
        public static void UpdateSysCof(int AddSeaC = 0, int AddCount = 0, int page = 0)
        {
            //TotalRec AddCount
            Helper.MySqlHelper.ExecuteNonQuery(@"UPDATE `crawlerwp`.`sys_status` SET `sys_status`.`Value` = `sys_status`.`Value`+@AddSeaC WHERE (`sys_status`.`Key` = 'TotalFXC');
            UPDATE `crawlerwp`.`sys_status` SET `sys_status`.`Value` = `sys_status`.`Value`+@AddCount WHERE (`sys_status`.`Key` = 'TotalSLC');
            UPDATE `crawlerwp`.`sys_status` SET `sys_status`.`Value` = `sys_status`.`Value`+@page WHERE (`sys_status`.`Key` = 'TotalSSC');
            UPDATE `crawlerwp`.`sys_status` SET `sys_status`.`Value` = `sys_status`.`Value`+1  WHERE (`sys_status`.`Key` = 'TotalEXC');",
                new MySqlParameter("@AddSeaC", AddSeaC), 
                new MySqlParameter("@AddCount", AddCount),
                new MySqlParameter("@page", page));
        }

        /// <summary>
        /// 执行事务
        /// </summary>
        /// <param name="taskModel"></param>
        public static void ExecuteTask(crawler_task taskModel)
        {
            UpdateTask(taskModel, "执行中...", 10);
            int stopCount = 0, //停止阀值
                completeCount = 0,//已完成记录
                allCount = 0;//搜索总记录
            //基础配置字典
            Dictionary<string, string> cof = CrawlerMD.GetCralerCof(taskModel.ConfigId);
            //搜索字典
            Dictionary<string, string> cofSera = new Dictionary<string, string>();
            crawler_config cofModel = crawler_configDAL.GetById(taskModel.ConfigId);
            if (cofModel == null || cofModel.TableName.Trim().Equals(""))
            {
                AddLog("没有找到搜索所对应的正则配置；任务：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
                UpdateTask(taskModel, "没有找到搜索所对应的正则配置", 11);
                return;
            }
            cofModel.StopPageCount = cofModel.StopPageCount <= 0 ? 3 : cofModel.StopPageCount;
            //字段名
            List<string> lsTbCols = cofModel.Fields.Split('|').ToList();
            // lsTbCols = lsTbCols.OrderBy(a => a).ToList();
            //正则配置｛每个字段对应一个｝
            List<crawler_regex> lsRegex = crawler_regexDAL.ListByWhere(new crawler_regex() { ConfigId = taskModel.ConfigId }, "", "ConfigId").ToList();
            if (lsRegex != null && lsRegex.Count > 0)
            {
                lsRegex = lsRegex.Where(a => a.Regex != null && !a.Regex.Trim().Equals("")).ToList();
            }
            if (lsRegex == null || lsRegex.Count <= 0)
            {
                AddLog("没有找到搜索所对应的正则配置；任务：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
                UpdateTask(taskModel, "没有找到搜索所对应的正则配置", 11);
                return;
            }
            // lsRegex = lsRegex.OrderBy(a => a.ColName).ToList();
            //sql
            string sql = ("INSERT INTO `" + cofModel.TableName.Trim() + "`(`" + string.Join("`, `", lsTbCols) + "`,`SYS_AddTime`,`TaskId`)VALUES(@" + string.Join(", @", lsTbCols) + ",@SYS_AddTime," + taskModel.Id + ");");
            //正则
            //所有记录
            Regex allRowRegex = new Regex(cofModel.AllRowConfig, RegexOptions.IgnoreCase | RegexOptions.Compiled | RegexOptions.Singleline);
            AddLog("搜索任务开始：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
            int tp = 0;
            for (int p = 1; p <= cofModel.MaxPage; p++)
            {
                
                if (stopCount >= cofModel.StopPageCount || completeCount >= taskModel.SingleCount)
                {
                    break;
                }
                int reqp = p;
                if (cofModel.PageSize > 0)
                {
                    reqp = (reqp - 1) * cofModel.PageSize;
                }
                tp++;
                cofSera = CrawlerMD.PackageCof(cof, reqp.ToString(), taskModel.KeyWords);
                StringBuilder sb = CrawlerMD.GetHtml(cofSera);
                string res = (sb == null) ? "" : sb.ToString();
                try
                {
                    //匹配一页所有记录
                    MatchCollection mcls = allRowRegex.Matches(res);
                    List<MySqlParameter> lsParam = new List<MySqlParameter>();
                    int c = mcls.Count;
                    if (c <= 0)
                    {
                        stopCount++;
                        continue;
                    }
                    allCount += c;
                    for (int i = 0; i < c; i++)
                    {
                        if (completeCount >= taskModel.SingleCount)
                        {
                            break;
                        }
                        //单条记录处理
                        if (!mcls[i].Success)
                        {
                            continue;
                        }
                        lsParam.Clear();
                        string exSql = null;
                        bool isok = true;
                        int defC = 0;
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
                                else
                                {
                                    defC++;
                                }
                            }
                            else { defC++; }
                            v = StrReplaceHtml(v).Replace("</", "");
                            if (exSql == null)
                            {
                                exSql = ("SELECT * FROM `" + cofModel.TableName + "` WHERE `" + item + "`=@" + item + " AND TaskId IN(0," + taskModel.Id + ");");
                                if (Helper.MySqlHelper.ExecuteScalar(exSql, new MySqlParameter("@" + item, v)) != null)
                                {
                                    isok = false;
                                    break;
                                }
                            }
                            lsParam.Add(new MySqlParameter("@" + item, v));
                        }
                        if (!isok || defC >= lsTbCols.Count)
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
                    AddLog("系统异常：" + ex.Message);
                    stopCount++;
                }
            }
            UpdateTask(taskModel, "", 12);
            AddLog("搜索任务完毕：" + taskModel.KeyWords + "   配置：" + cofModel.Name);
            UpdateSysCof(allCount, completeCount,tp);
        }


        public static int GetTaskCount()
        {
            object cObj = Helper.MySqlHelper.ExecuteScalar("UPDATE crawler_task SET crawler_task.`Status`=13 WHERE crawler_task.`Status` IN (1, 10,11, 12) AND crawler_task.ExpireTime < UNIX_TIMESTAMP(NOW());SELECT COUNT(1) AS count FROM crawler_task WHERE crawler_task.`Status` IN (1,10,11, 12) AND ( crawler_task.ExpireTime >= UNIX_TIMESTAMP(NOW()) ) AND ( crawler_task.UpdateTime + crawler_task.Cycle ) <= UNIX_TIMESTAMP(NOW());");
            int count = 0;
            if (cObj == null)
            {
                return 0;
            }
            count = int.Parse(cObj.ToString());
            return count;
        }
        /// <summary>
        ///  开始执行事务
        /// </summary>
        /// <param name="MaxThread">最大线程数量</param>
        public static void BeginExecute(bool isdesc=false)
        {
            Form1.isbegin = true;
            //MaxThread = MaxThread <= 0 ? 1 : (MaxThread > 20 ? 20 : MaxThread);
            //List<Thread> lsThread = new List<Thread>();
            //for (int i = 0; i < MaxThread; i++)
            //{
            //    Thread th = null;
            //    lsThread.Add(th);
            //}
            //更新过期事务
            //获得当前需要执行的事务总数
            object cObj = Helper.MySqlHelper.ExecuteScalar("UPDATE crawler_task SET crawler_task.`Status`=13 WHERE crawler_task.`Status` IN (1, 10,11, 12) AND crawler_task.ExpireTime < UNIX_TIMESTAMP(NOW());SELECT COUNT(1) AS count FROM crawler_task WHERE crawler_task.`Status` IN (1,10,11, 12) AND ( crawler_task.ExpireTime >= UNIX_TIMESTAMP(NOW()) ) AND ( crawler_task.UpdateTime + crawler_task.Cycle ) <= UNIX_TIMESTAMP(NOW());");
            int count = 0;
            if (cObj == null)
            {
                Form1.isbegin = false;
                return;
            }
            count = int.Parse(cObj.ToString());
            if (count <= 0)
            {
                Form1.isbegin = false;
                return;
            }
            AddLog("开始搜索任务");
            for (int p = 1; p <= count; p++)
            {
                Form1.isbegin = true;
                List<crawler_task> lsTask = crawler_taskDAL.ListByPage(1, 1, "`UpdateTime`", isdesc, "crawler_task.`Status` in(1,10,11,12)", "(crawler_task.ExpireTime>=UNIX_TIMESTAMP(NOW()))", "(crawler_task.UpdateTime+crawler_task.Cycle)<=UNIX_TIMESTAMP(NOW())").ToList();
                if (lsTask == null || lsTask.Count <= 0)
                {
                    continue;
                }
                foreach (var item in lsTask)
                {
                    ExecuteTask(item);
                    #region MyRegion 多线程算法，还没想好
                    //int t = (--MaxThread);
                    //if (t < 0)
                    //{
                    //    while (true)
                    //    {
                    //        t = -1;
                    //        for (int i = 0, tc = lsThread.Count; i < tc; i++)
                    //        {
                    //            if (lsThread[i] == null || lsThread[i].ThreadState == ThreadState.Stopped)
                    //            {
                    //                t = i;
                    //                break;
                    //            }
                    //        }
                    //        if (t >= 0) { break; }

                    //    }
                    //}
                    //lsThread[t] = new Thread(new ThreadStart(delegate
                    //{
                    //    ExecuteTask(item);
                    //}));
                    //lsThread[t].IsBackground = true;
                    //lsThread[t].Start(); 
                    #endregion
                }
            }
            AddLog("完成搜索任务");
            Form1.isbegin = false;
        }
    }
}
