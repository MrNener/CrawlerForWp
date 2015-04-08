using Helper;
using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace CrawlerForWp {
    public static class  crawler_configDAL {

        public static crawler_config ToModel(DataRow row) {
            crawler_config model = new crawler_config();
            model.Id = (System.Int32)row["Id"];
            model.Name = (System.String)row["Name"];
            model.SubmitUrl = (System.String)row["SubmitUrl"];
            model.KeyWordField = (System.String)row["KeyWordField"];
            model.PageField = (System.String)row["PageField"];
            model.Fields = (System.String)row["Fields"];
            model.FieldsNote = (System.String)row["FieldsNote"];
            model.AllRowConfig = (System.String)row["AllRowConfig"];
            model.MaxPage = (System.Int32)row["MaxPage"];
            model.StopPageCount = (System.Int32)row["StopPageCount"];
            model.TableName = (System.String)row["TableName"];
            model.AddTime = (System.Int32)row["AddTime"];
            model.AddUID = (System.Int32)row["AddUID"];
            model.UpdateTime = (System.Int32)row["UpdateTime"];
            model.Status = (System.Int32)row["Status"];
            return model;
        }

        /// <summary>
        /// 插入一条记录
        /// </summary>
        /// <param name="model">crawler_config类的对象</param>
        /// <returns>object 主键</returns>
        public static object Insert(crawler_config model) {
            object obj;
            string isNullId = Convert.ToString(model.Id);
            if (isNullId.Equals("") || isNullId.Equals("0") || isNullId.Equals(new Guid().ToString()) || isNullId.Equals(null))
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_config`(`Name`, `SubmitUrl`, `KeyWordField`, `PageField`, `Fields`, `FieldsNote`, `AllRowConfig`, `MaxPage`, `StopPageCount`, `TableName`, `AddTime`, `AddUID`, `UpdateTime`, `Status`) VALUES(@Name, @SubmitUrl, @KeyWordField, @PageField, @Fields, @FieldsNote, @AllRowConfig, @MaxPage, @StopPageCount, @TableName, @AddTime, @AddUID, @UpdateTime, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Name", model.Name)
                        ,new MySqlParameter("@SubmitUrl", model.SubmitUrl)
                        ,new MySqlParameter("@KeyWordField", model.KeyWordField)
                        ,new MySqlParameter("@PageField", model.PageField)
                        ,new MySqlParameter("@Fields", model.Fields)
                        ,new MySqlParameter("@FieldsNote", model.FieldsNote)
                        ,new MySqlParameter("@AllRowConfig", model.AllRowConfig)
                        ,new MySqlParameter("@MaxPage", model.MaxPage)
                        ,new MySqlParameter("@StopPageCount", model.StopPageCount)
                        ,new MySqlParameter("@TableName", model.TableName)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@AddUID", model.AddUID)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
                        ,new MySqlParameter("@Status", model.Status)
                    );
            }
            else
            {
               obj = Helper.MySqlHelper.ExecuteScalar(@"INSERT INTO `crawler_config`(`Id`, `Name`, `SubmitUrl`, `KeyWordField`, `PageField`, `Fields`, `FieldsNote`, `AllRowConfig`, `MaxPage`, `StopPageCount`, `TableName`, `AddTime`, `AddUID`, `UpdateTime`, `Status`) VALUES(@Id, @Name, @SubmitUrl, @KeyWordField, @PageField, @Fields, @FieldsNote, @AllRowConfig, @MaxPage, @StopPageCount, @TableName, @AddTime, @AddUID, @UpdateTime, @Status); SELECT @@IDENTITY AS Id ;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Name", model.Name)
                        ,new MySqlParameter("@SubmitUrl", model.SubmitUrl)
                        ,new MySqlParameter("@KeyWordField", model.KeyWordField)
                        ,new MySqlParameter("@PageField", model.PageField)
                        ,new MySqlParameter("@Fields", model.Fields)
                        ,new MySqlParameter("@FieldsNote", model.FieldsNote)
                        ,new MySqlParameter("@AllRowConfig", model.AllRowConfig)
                        ,new MySqlParameter("@MaxPage", model.MaxPage)
                        ,new MySqlParameter("@StopPageCount", model.StopPageCount)
                        ,new MySqlParameter("@TableName", model.TableName)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@AddUID", model.AddUID)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
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
            int rows = Helper.MySqlHelper.ExecuteNonQuery("DELETE FROM `crawler_config` WHERE `Id` = @Id", new MySqlParameter("@Id", Id));
            return rows > 0;
        }

        /// <summary>
        /// 更新一条记录
        /// </summary>
        /// <param name="model">crawler_config类的对象</param>
        /// <returns>更新是否成功</returns>
        public static bool Update(crawler_config model) {
            int count = Helper.MySqlHelper.ExecuteNonQuery("UPDATE `crawler_config` SET `Name`=@Name, `SubmitUrl`=@SubmitUrl, `KeyWordField`=@KeyWordField, `PageField`=@PageField, `Fields`=@Fields, `FieldsNote`=@FieldsNote, `AllRowConfig`=@AllRowConfig, `MaxPage`=@MaxPage, `StopPageCount`=@StopPageCount, `TableName`=@TableName, `AddTime`=@AddTime, `AddUID`=@AddUID, `UpdateTime`=@UpdateTime, `Status`=@Status WHERE `Id`=@Id;"
                        ,new MySqlParameter("@Id", model.Id)
                        ,new MySqlParameter("@Name", model.Name)
                        ,new MySqlParameter("@SubmitUrl", model.SubmitUrl)
                        ,new MySqlParameter("@KeyWordField", model.KeyWordField)
                        ,new MySqlParameter("@PageField", model.PageField)
                        ,new MySqlParameter("@Fields", model.Fields)
                        ,new MySqlParameter("@FieldsNote", model.FieldsNote)
                        ,new MySqlParameter("@AllRowConfig", model.AllRowConfig)
                        ,new MySqlParameter("@MaxPage", model.MaxPage)
                        ,new MySqlParameter("@StopPageCount", model.StopPageCount)
                        ,new MySqlParameter("@TableName", model.TableName)
                        ,new MySqlParameter("@AddTime", model.AddTime)
                        ,new MySqlParameter("@AddUID", model.AddUID)
                        ,new MySqlParameter("@UpdateTime", model.UpdateTime)
                        ,new MySqlParameter("@Status", model.Status)
            );
        return count > 0;
        }

        /// <summary>
        /// 获得一条记录
        /// </summary>
        /// <param name="Id">主键</param>
        /// <returns>crawler_config类的对象</returns>
        public static crawler_config GetById(System.Int32 Id) {
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Name`, `SubmitUrl`, `KeyWordField`, `PageField`, `Fields`, `FieldsNote`, `AllRowConfig`, `MaxPage`, `StopPageCount`, `TableName`, `AddTime`, `AddUID`, `UpdateTime`, `Status` FROM `crawler_config` WHERE `Id`=@Id", new MySqlParameter("@Id", Id));
            if (dt.Rows.Count > 1) {
                throw new Exception("more than 1 row was found");
            }
            else if (dt.Rows.Count <= 0) {
                return null;
            }
            DataRow row = dt.Rows[0];
            crawler_config model = ToModel(row);
            return model;
        }

        /// <summary>
        /// 获得所有记录
        /// </summary>
        /// <returns>crawler_config类的对象的枚举</returns>
        public static IEnumerable<crawler_config> ListAll() {
            List<crawler_config> list = new List<crawler_config>();
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable("SELECT `Id`, `Name`, `SubmitUrl`, `KeyWordField`, `PageField`, `Fields`, `FieldsNote`, `AllRowConfig`, `MaxPage`, `StopPageCount`, `TableName`, `AddTime`, `AddUID`, `UpdateTime`, `Status` FROM `crawler_config`;");
            foreach (DataRow row in dt.Rows)  {
                list.Add(ToModel(row));
            }
            return list;
        }

        /// <summary>
        /// 通过条件获得满足条件的记录
        /// </summary>
        /// <param name="model">crawler_config类的对象</param>
        /// <param name="whereStr">其他的sql 语句  </param>
        /// <param name="fields">需要的条件的字段名</param>
        /// <returns>满足条件的记录</returns>
         public static IEnumerable<crawler_config> ListByWhere(crawler_config model,string whereStr, params string[] fields)
         {
             List<MySqlParameter> lsParameter = new List<MySqlParameter>();
             string str = Helper.GenericSQLGenerator.GetWhereStr<crawler_config>(model, "crawler_config", out lsParameter, fields);
             if(whereStr!=null&&whereStr.Trim().Length>0){str=str+" and "+whereStr;}
             List<crawler_config> list = new List<crawler_config>();
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
        public static IEnumerable<crawler_config> ListByPage(int page = 1, int num = 10, string orderBy = "Id", bool isDesc = true, params string[] whereArr)
        {
            string whereStr = "";
            List<string> ls = new List<string>();
            foreach (var v in whereArr) { if (v != null && v != "") { ls.Add(v); } }
            whereArr = ls.ToArray();
            if (num < 1 || page < 1) { return null; }
            List<crawler_config> list = new List<crawler_config>();
            if (whereArr != null && whereArr.Length > 0) { whereStr = " and " + string.Join(" and ", whereArr); }
            if (isDesc) { orderBy += " desc"; }
            DataTable dt = Helper.MySqlHelper.ExecuteDataTable(string.Format(@"SELECT * FROM `crawler_config` WHERE (1=1) {0} ORDER BY {1} ASC LIMIT {2}, {3};" , whereStr,orderBy,  ((page -1)* num), num));
            foreach (DataRow row in dt.Rows) { list.Add(ToModel(row)); }
            return list;
        }
    }
}
