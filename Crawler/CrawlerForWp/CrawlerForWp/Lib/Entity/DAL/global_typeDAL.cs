﻿using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  global_typeDAL {

        public static global_type ToModel(DataRow row) {
            global_type model = new global_type();
            model.Id = (System.Int32)row["Id"];
            model.Key = (System.String)row["Key"];
            model.Note = (System.String)Helper.MySqlHelper.FromDBValue(row["Note"]);
            model.Status = (System.Int32)row["Status"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">global_type类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(global_type model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `global_type`(`Key`, `Note`, `Status`) VALUES(@Key, @Note, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Key", model.Key)
                        ,new MySqlParameter("@Note", Helper.MySqlHelper.ToDBValue(model.Note))
                        ,new MySqlParameter("@Status", model.Status)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `global_type`(`Id`, `Key`, `Note`, `Status`) VALUES(@Id, @Key, @Note, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Key", model.Key)
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
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `global_type` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">global_type类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(global_type model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `global_type` SET `Key`=@Key, `Note`=@Note, `Status`=@Status WHERE `Id`=@Id;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Key", model.Key)
                        ,new MySqlParameter("@Note", Helper.MySqlHelper.ToDBValue(model.Note))
                        ,new MySqlParameter("@Status", model.Status)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>global_type类的对象</returns>
        public static global_type GetById(System.Int32 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Key`, `Note`, `Status` FROM `global_type` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            global_type model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>global_type类的对象的枚举</returns>
        public static IEnumerable<global_type> ListAll() {
            List<global_type> list = new List<global_type>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Key`, `Note`, `Status` FROM `global_type`;");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">global_type类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<global_type> ListByWhere(global_type model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<global_type>(model, "global_type", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<global_type> list = new List<global_type>();
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
        public static IEnumerable<global_type> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<global_type> list = new List<global_type>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `global_type` WHERE (1=1) {0} ORDER BY {1}  LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
