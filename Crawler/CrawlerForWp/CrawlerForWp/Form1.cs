using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using Helper;
using System.Threading;
using System.IO;
using System.Text.RegularExpressions;
using MySql.Data.MySqlClient;

namespace CrawlerForWp
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            crawler_task taskModel = crawler_taskDAL.GetById(1);
            HandleHtml.ExecuteTask(taskModel);
            /**Todo List
             *筛选事务->周期计算，过期计算，过期更新
             *多线程->根据配置选择线程数量，任务锁死
             *计时器->自动获取配置，自动执行事务
             *配置更新与获取
             *
             */
        }


    }
}
