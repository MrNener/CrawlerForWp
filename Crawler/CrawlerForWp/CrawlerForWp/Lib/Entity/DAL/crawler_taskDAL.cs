using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  crawler_taskDAL {

        public static crawler_task ToModel(DataRow row) {
            crawler_task model = new crawler_task();
            model.Id = (System.Int32)row["Id"];
            model.KeyWords = (System.String)row["KeyWords"];
            model.ConfigId = (System.Int32)row["ConfigId"];
            model.SingleCount = (System.Int32)row["SingleCount"];
            model.Cycle = (System.Int32)row["Cycle"];
            model.ExpireTime = (System.Int32)row["ExpireTime"];
            model.AddTime = (System.Int32)row["AddTime"];
            model.UpdateTime = (System.Int32)row["UpdateTime"];
            model.Note = (System.String)Helper.MySqlHelper.FromDBValue(row["Note"]);
            model.Status = (System.Int32)row["Status"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">crawler_task类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(crawler_task model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_task`(`KeyWords`, `ConfigId`, `SingleCount`, `Cycle`, `ExpireTime`, `AddTime`, `UpdateTime`, `Note`, `Status`) VALUES(@KeyWords, @ConfigId, @SingleCount, @Cycle, @ExpireTime, @AddTime, @UpdateTime, @Note, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@KeyWords", model.KeyWords)
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@SingleCount", model.SingleCount)
                        ,new MySqlParameter("@Cycle", model.Cycle)
                        ,new MySqlParameter("@ExpireTime", model.ExpireTime)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
                        ,new MySqlParameter("@Note", Helper.MySqlHelper.ToDBValue(model.Note))
                        ,new MySqlParameter("@Status", model.Status)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_task`(`Id`, `KeyWords`, `ConfigId`, `SingleCount`, `Cycle`, `ExpireTime`, `AddTime`, `UpdateTime`, `Note`, `Status`) VALUES(@Id, @KeyWords, @ConfigId, @SingleCount, @Cycle, @ExpireTime, @AddTime, @UpdateTime, @Note, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@KeyWords", model.KeyWords)
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@SingleCount", model.SingleCount)
                        ,new MySqlParameter("@Cycle", model.Cycle)
                        ,new MySqlParameter("@ExpireTime", model.ExpireTime)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
                        ,new MySqlParameter("@Note", Helper.MySqlHelper.ToDBValue(model.Note))
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
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `crawler_task` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">crawler_task类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(crawler_task model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `crawler_task` SET `KeyWords`=@KeyWords, `ConfigId`=@ConfigId, `SingleCount`=@SingleCount, `Cycle`=@Cycle, `ExpireTime`=@ExpireTime, `AddTime`=@AddTime, `UpdateTime`=@UpdateTime, `Note`=@Note, `Status`=@Status WHERE `Id`=@Id;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@KeyWords", model.KeyWords)
                        ,new MySqlParameter("@ConfigId", model.ConfigId)
                        ,new MySqlParameter("@SingleCount", model.SingleCount)
                        ,new MySqlParameter("@Cycle", model.Cycle)
                        ,new MySqlParameter("@ExpireTime", model.ExpireTime)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
                        ,new MySqlParameter("@Note", Helper.MySqlHelper.ToDBValue(model.Note))
                        ,new MySqlParameter("@Status", model.Status)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>crawler_task类的对象</returns>
        public static crawler_task GetById(System.Int32 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `KeyWords`, `ConfigId`, `SingleCount`, `Cycle`, `ExpireTime`, `AddTime`, `UpdateTime`, `Note`, `Status` FROM `crawler_task` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            crawler_task model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>crawler_task类的对象的枚举</returns>
        public static IEnumerable<crawler_task> ListAll() {
            List<crawler_task> list = new List<crawler_task>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `KeyWords`, `ConfigId`, `SingleCount`, `Cycle`, `ExpireTime`, `AddTime`, `UpdateTime`, `Note`, `Status` FROM `crawler_task`;");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">crawler_task类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<crawler_task> ListByWhere(crawler_task model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<crawler_task>(model, "crawler_task", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<crawler_task> list = new List<crawler_task>();
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
        public static IEnumerable<crawler_task> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<crawler_task> list = new List<crawler_task>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `crawler_task` WHERE (1=1) {0} ORDER BY {1} ASC LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
