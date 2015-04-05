using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Text;
namespace Helper
{
    public static class GenericSQLGenerator
    {
        public static string GetWhereStr<T>(T entity, string tableName, out List<MySqlParameter> list, params string[] fields) where T : new()
        {
            StringBuilder sbu = new StringBuilder();
            list = new List<MySqlParameter>();

            sbu.Append("");
            sbu.Append("select * from `" + tableName + "` where (1=1)");
            if (fields != null)
            {
                //遍历每一个要生成MySql的字段，取出内容
                foreach (string field in fields)
                {
                    object value = entity.GetType().GetProperty(field).GetValue(entity, null);
                    if (value is int || value is double || value is decimal || value is double || value is long || value is float)
                    {

                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", value));

                    }
                    else if (value is DateTime)
                    {
                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", Convert.ToDateTime(value)));

                    }
                    else if (value is Guid)
                    {
                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", new Guid(value.ToString())));

                    }
                    else if (value is Boolean)
                    {
                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", Convert.ToBoolean(value)));

                    }
                    else if (value is String || value is Char)
                    {
                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", Convert.ToString(value)));

                    }
                    else
                    {
                        sbu.AppendFormat(" and (`{0}`=@{0})", field);
                        list.Add(new MySqlParameter("@" + field + "", Helper.MySqlHelper.ToDBValue(value)));
                    }
                }
            }
            return (sbu.ToString());
        }
    }
}