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
        System.Timers.Timer t1 = new System.Timers.Timer();
        Thread main = null;
        public static bool isbegin = false;
        private static int maxthreda = 0;
        private static int interUpdate = 0;
        public Form1()
        {
            InitializeComponent();
        }

        private void GoCrawler(object sender, EventArgs e)
        {
            t1.Stop();
            if (maxthreda <= 0)
            {
                var ls = sys_configDAL.ListByWhere(new sys_config() { Key = "MaxThread" }, null, "Key").ToList();
                if (ls == null || ls.Count <= 0 || ls[0] == null)
                {
                    maxthreda = 2;
                }
                else
                {
                    maxthreda = ls[0].Value;
                    maxthreda = maxthreda <= 0 ? 1 : (maxthreda > 10 ? 10 : maxthreda);
                }
            }
            var lsInt = sys_configDAL.ListByWhere(new sys_config() { Key = "MonitorInterval" }, null, "Key").ToList();
            if ((lsInt == null || lsInt.Count <= 0 || lsInt[0] == null)==false)
            {
                if (interUpdate< lsInt[0].UpdateTime)
                {
                    t1.Interval = lsInt[0].Value <= 0 ? t1.Interval : (lsInt[0].Value > 43200 ? t1.Interval : lsInt[0].Value * 1000);
                }
                interUpdate = lsInt[0].UpdateTime;
            }
            label1.Invoke(new Action(() =>
            {
                label1.Text = "监测中...";
            }));
            if (isbegin == false)
            {
                label1.Invoke(new Action(() =>
                {
                    label1.Text = "执行中...";
                }));
                isbegin = true;
                if (CrawlerMD.GetTaskCount() > 0)
                {
                    try
                    {
                        for (int i = 0; i < maxthreda; i++)
                        {
                            bool isdes = (i % 2 == 0) ? false : true;
                            Thread th = new Thread(new ThreadStart(delegate
                            {
                                CrawlerMD.BeginExecute(isdes);

                            }));
                            th.IsBackground = true;
                            th.Start();
                            Thread.Sleep(5000);
                        }
                    }
                    catch (Exception)
                    {
                        isbegin = false;
                        t1.Start();
                        return;
                    }
                }
                isbegin = false;
                label1.Invoke(new Action(() =>
               {
                   label1.Text = "监测中...";
               }));
                GC.Collect();
                // isbegin = false;
            }
            else
            {
                label1.Invoke(new Action(() =>
                {
                    label1.Text = "执行中...";
                }));
            }
            t1.Start();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            t1.Interval = 12000;
            t1.Elapsed += GoCrawler;
            t1.AutoReset = true;
            t1.Start();
        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            this.WindowState = FormWindowState.Minimized;
            e.Cancel = true;
        }
    }
}
