using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  weipu_resultDAL {

        public static weipu_result ToModel(DataRow row) {
            weipu_result model = new weipu_result();
            model.Id = (System.Int64)row["Id"];
            model.Url = (System.String)row["Url"];
            model.Title = (System.String)row["Title"];
            model.Author = (System.String)row["Author"];
            model.Journal = (System.String)row["Journal"];
            model.Abstract = (System.String)row["Abstract"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">weipu_result类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(weipu_result model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `weipu_result`(`Url`, `Title`, `Author`, `Journal`, `Abstract`) VALUES(@Url, @Title, @Author, @Journal, @Abstract); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Url", model.Url)
                        ,new MySqlParameter("@Title", model.Title)
                        ,new MySqlParameter("@Author", model.Author)
                        ,new MySqlParameter("@Journal", model.Journal)
                        ,new MySqlParameter("@Abstract", model.Abstract)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `weipu_result`(`Id`, `Url`, `Title`, `Author`, `Journal`, `Abstract`) VALUES(@Id, @Url, @Title, @Author, @Journal, @Abstract); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Url", model.Url)
                        ,new MySqlParameter("@Title", model.Title)
                        ,new MySqlParameter("@Author", model.Author)
                        ,new MySqlParameter("@Journal", model.Journal)
                        ,new MySqlParameter("@Abstract", model.Abstract)
                    );
            }
        return obj;
        }

        /// <summary>
        /// 删除一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>删除是否成功</returns>
        public static bool DeleteById(System.Int64 Id) {
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `weipu_result` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">weipu_result类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(weipu_result model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `weipu_result` SET `Url`=@Url, `Title`=@Title, `Author`=@Author, `Journal`=@Journal, `Abstract`=@Abstract WHERE `Id`=@Id;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Url", model.Url)
                        ,new MySqlParameter("@Title", model.Title)
                        ,new MySqlParameter("@Author", model.Author)
                        ,new MySqlParameter("@Journal", model.Journal)
                        ,new MySqlParameter("@Abstract", model.Abstract)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>weipu_result类的对象</returns>
        public static weipu_result GetById(System.Int64 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Url`, `Title`, `Author`, `Journal`, `Abstract` FROM `weipu_result` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            weipu_result model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>weipu_result类的对象的枚举</returns>
        public static IEnumerable<weipu_result> ListAll() {
            List<weipu_result> list = new List<weipu_result>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Url`, `Title`, `Author`, `Journal`, `Abstract` FROM `weipu_result`;");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">weipu_result类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<weipu_result> ListByWhere(weipu_result model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<weipu_result>(model, "weipu_result", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<weipu_result> list = new List<weipu_result>();
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
        public static IEnumerable<weipu_result> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<weipu_result> list = new List<weipu_result>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `weipu_result` WHERE (1=1) {0} ORDER BY {1} ASC LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
