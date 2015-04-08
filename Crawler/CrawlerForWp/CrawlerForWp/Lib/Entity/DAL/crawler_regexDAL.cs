using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  crawler_regexDAL {

        public static crawler_regex ToModel(DataRow row) {
            crawler_regex model = new crawler_regex();
            model.Id = (System.Int32)row["Id"];
            model.ConfigId = (System.Int32)row["ConfigId"];
            model.ColName = (System.String)row["ColName"];
            model.ColNote = (System.String)Helper.MySqlHelper.FromDBValue(row["ColNote"]);
            model.Regex = (System.String)row["Regex"];
            model.DefaultValue = (System.String)row["DefaultValue"];
            model.Prdfix = (System.String)row["Prdfix"];
            model.Suffix = (System.String)row["Suffix"];
            model.Status = (System.Int32)row["Status"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">crawler_regex类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(crawler_regex model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_regex`(`ConfigId`, `ColName`, `ColNote`, `Regex`, `DefaultValue`, `Prdfix`, `Suffix`, `Status`) VALUES(@ConfigId, @ColName, @ColNote, @Regex, @DefaultValue, @Prdfix, @Suffix, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@ColName", model.ColName)
                        ,new MySqlParameter("@ColNote", Helper.MySqlHelper.ToDBValue(model.ColNote))
                        ,new MySqlParameter("@Regex", model.Regex)
                        ,new MySqlParameter("@DefaultValue", model.DefaultValue)
                        ,new MySqlParameter("@Prdfix", model.Prdfix)
                        ,new MySqlParameter("@Suffix", model.Suffix)
                        ,new MySqlParameter("@Status", model.Status)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_regex`(`Id`, `ConfigId`, `ColName`, `ColNote`, `Regex`, `DefaultValue`, `Prdfix`, `Suffix`, `Status`) VALUES(@Id, @ConfigId, @ColName, @ColNote, @Regex, @DefaultValue, @Prdfix, @Suffix, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@ColName", model.ColName)
                        ,new MySqlParameter("@ColNote", Helper.MySqlHelper.ToDBValue(model.ColNote))
                        ,new MySqlParameter("@Regex", model.Regex)
                        ,new MySqlParameter("@DefaultValue", model.DefaultValue)
                        ,new MySqlParameter("@Prdfix", model.Prdfix)
                        ,new MySqlParameter("@Suffix", model.Suffix)
                        ,new MySqlParameter("@Status", model.Status)
                    );
            }
        return obj;
        }

        /// <summary>
        /// 删除一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>删除是否成功</returns>
        public static bool DeleteById(System.Int32 Id) {
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `crawler_regex` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">crawler_regex类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(crawler_regex model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `crawler_regex` SET `ConfigId`=@ConfigId, `ColName`=@ColName, `ColNote`=@ColNote, `Regex`=@Regex, `DefaultValue`=@DefaultValue, `Prdfix`=@Prdfix, `Suffix`=@Suffix, `Status`=@Status WHERE `Id`=@Id;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@ColName", model.ColName)
                        ,new MySqlParameter("@ColNote", Helper.MySqlHelper.ToDBValue(model.ColNote))
                        ,new MySqlParameter("@Regex", model.Regex)
                        ,new MySqlParameter("@DefaultValue", model.DefaultValue)
                        ,new MySqlParameter("@Prdfix", model.Prdfix)
                        ,new MySqlParameter("@Suffix", model.Suffix)
                        ,new MySqlParameter("@Status", model.Status)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>crawler_regex类的对象</returns>
        public static crawler_regex GetById(System.Int32 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `ConfigId`, `ColName`, `ColNote`, `Regex`, `DefaultValue`, `Prdfix`, `Suffix`, `Status` FROM `crawler_regex` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            crawler_regex model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>crawler_regex类的对象的枚举</returns>
        public static IEnumerable<crawler_regex> ListAll() {
            List<crawler_regex> list = new List<crawler_regex>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `ConfigId`, `ColName`, `ColNote`, `Regex`, `DefaultValue`, `Prdfix`, `Suffix`, `Status` FROM `crawler_regex`;");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">crawler_regex类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<crawler_regex> ListByWhere(crawler_regex model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<crawler_regex>(model, "crawler_regex", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<crawler_regex> list = new List<crawler_regex>();
             MySqlParameter[] sqlparm = lsParameter.ToArray();
             DataTable dt = Helper.MySqlHelper.ExecuteDataTable(str, sqlparm);
             foreach (DataRow row in dt.Rows)
             {
                 list.Add(ToModel(row));
             }
             return list;
         }

        /// <summary>
        /// 分页查询
        /// </summary>
        /// <param name="page">页数（从1开始计数）</param>
        /// <param name="num">每页个数（从1开始计数）</param>
        /// <param name="orderBy">排序条件</param>
        /// <param name="isDesc">是否降序</param>
        /// <param name="whereArr">查询条件：例如ID=1,NAME='ADMIN'</param>
        /// <returns></returns>
        public static IEnumerable<crawler_regex> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<crawler_regex> list = new List<crawler_regex>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `crawler_regex` WHERE (1=1) {0} ORDER BY {1} ASC LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
