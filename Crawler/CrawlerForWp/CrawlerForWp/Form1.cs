using System;
using System.Collections.Generic;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Helper;
using System.Threading;
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
            Thread th = new Thread(new ThreadStart(delegate { CrawlerMD.BeginExecute(); }));
            th.IsBackground = true;
            th.Start();
            
            /**Todo List
             *筛选事务->周期计算，过期计算，过期更新   OK
             *多线程->根据配置选择线程数量，任务锁死
             *计时器->自动获取配置，自动执行事务
             *配置更新与获取
             *
             */
        }

        private void button2_Click(object sender, EventArgs e)
        {

        }


    }
}
