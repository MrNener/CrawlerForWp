using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  logDAL {

        public static log ToModel(DataRow row) {
            log model = new log();
            model.Id = (System.Int32)row["Id"];
            model.AddTime = (System.Int32)row["AddTime"];
            model.Type = (System.String)Helper.MySqlHelper.FromDBValue(row["Type"]);
            model.Contents = (System.String)row["Contents"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">log类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(log model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `log`(`AddTime`, `Type`, `Contents`) VALUES(@AddTime, @Type, @Contents) SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@Type", Helper.MySqlHelper.ToDBValue(model.Type))
                        ,new MySqlParameter("@Contents", model.Contents)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `log`(`Id`, `AddTime`, `Type`, `Contents`) VALUES(@Id, @AddTime, @Type, @Contents) SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@Type", Helper.MySqlHelper.ToDBValue(model.Type))
                        ,new MySqlParameter("@Contents", model.Contents)
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
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `log` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">log类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(log model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `log` SET `AddTime`=@AddTime, `Type`=@Type, `Contents`=@Contents WHERE `Id`=@Id"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@Type", Helper.MySqlHelper.ToDBValue(model.Type))
                        ,new MySqlParameter("@Contents", model.Contents)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>log类的对象</returns>
        public static log GetById(System.Int32 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `AddTime`, `Type`, `Contents` FROM `log` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            log model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>log类的对象的枚举</returns>
        public static IEnumerable<log> ListAll() {
            List<log> list = new List<log>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `AddTime`, `Type`, `Contents` FROM `log`");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">log类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<log> ListByWhere(log model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<log>(model, "log", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<log> list = new List<log>();
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
        public static IEnumerable<log> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<log> list = new List<log>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `log` WHERE (1=1) {0} ORDER BY {1} ASC LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
