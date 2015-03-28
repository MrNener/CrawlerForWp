using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Configuration;
using System.Data;
using MySql.Data.MySqlClient;

namespace Helper
{
    public static class MySqlHelper
    {
        public static readonly string connstr = "llll";//ConfigurationManager.ConnectionStrings["connstr"].ConnectionString;
        /// <summary>
        /// 打开数据库
        /// </summary>
        /// <returns></returns>
        public static MySqlConnection OpenConnection()
        {
            using (MySqlConnection conn = new MySqlConnection(connstr))
            {
                conn.Open();
                return conn;
            }
        }
        /// <summary>
        /// 执行返回受影响的行数
        /// </summary>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static int ExecuteNonQuery(string cmdText, params MySqlParameter[] parameters)
        {
            using (MySqlConnection conn = new MySqlConnection(connstr))
            {
                conn.Open();
                return ExecuteNonQuery(conn, cmdText, parameters);
            }
        }
        /// <summary>
        /// 执行返回第一行第一列
        /// </summary>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static object ExecuteScalar(string cmdText, params MySqlParameter[] parameters)
        {
            using (MySqlConnection conn = new MySqlConnection(connstr))
            {
                conn.Open();
                return ExecuteScalar(conn, cmdText, parameters);
            }
        }
        /// <summary>
        /// 执行返回DataSet
        /// </summary>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static DataSet ExecuteDataSet(string cmdText, params MySqlParameter[] parameters)
        {
            using (MySqlConnection con = new MySqlConnection(connstr))
            {
                con.Open();
                return ExecuteDataSet(con, cmdText, parameters);
            }
        }
        /// <summary>
        /// 执行返回DataTable
        /// </summary>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static DataTable ExecuteDataTable(string cmdText, params MySqlParameter[] parameters)
        {
            using (MySqlConnection con = new MySqlConnection(connstr))
            {
                con.Open();
                return ExecuteDataTable(con, cmdText, parameters);
            }
        }
        /// <summary>
        /// 执行返回受影响的行数
        /// </summary>
        /// <param name="conn"></param>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static int ExecuteNonQuery(MySqlConnection conn, string cmdText,
           params MySqlParameter[] parameters)
        {
            using (MySqlCommand cmd = conn.CreateCommand())
            {
                cmd.CommandText = cmdText;
                cmd.Parameters.AddRange(parameters);
                return cmd.ExecuteNonQuery();
            }
        }
        /// <summary>
        /// 执行返回第一行第一列
        /// </summary>
        /// <param name="conn"></param>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static object ExecuteScalar(MySqlConnection conn, string cmdText,
            params MySqlParameter[] parameters)
        {
            using (MySqlCommand cmd = conn.CreateCommand())
            {
                cmd.CommandText = cmdText;
                cmd.Parameters.AddRange(parameters);
                return cmd.ExecuteScalar();
            }
        }
        /// <summary>
        /// 执行返回DataTable
        /// </summary>
        /// <param name="con"></param>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static DataTable ExecuteDataTable(MySqlConnection con, string cmdText, params MySqlParameter[] parameters)
        {
            return ExecuteDataSet(con, cmdText, parameters).Tables[0];
        }
        /// <summary>
        /// 执行返回DataSet
        /// </summary>
        /// <param name="con"></param>
        /// <param name="cmdText"></param>
        /// <param name="parameters"></param>
        /// <returns></returns>
        public static DataSet ExecuteDataSet(MySqlConnection con, string cmdText, params MySqlParameter[] parameters)
        {
            using (MySqlCommand cmd = con.CreateCommand())
            {
                cmd.CommandText = cmdText;
                cmd.Parameters.AddRange(parameters);
                using (MySqlDataAdapter adapter = new MySqlDataAdapter(cmd))
                {
                    DataSet ds = new DataSet();
                    adapter.FillSchema(ds, SchemaType.Source);
                    adapter.Fill(ds);
                    return ds;
                }
            }
        }
        /// <summary>
        /// null 转换为DBNull
        /// </summary>
        /// <param name="value"></param>
        /// <returns></returns>
        public static object ToDBValue(this object value)
        {
            return value == null ? DBNull.Value : value;
        }
        /// <summary>
        /// DBNull转换为null
        /// </summary>
        /// <param name="dbValue"></param>
        /// <returns></returns>
        public static object FromDBValue(this object dbValue)
        {
            return dbValue == DBNull.Value ? null : dbValue;
        }
    }
}