using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace HtmlReplace
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            textBox1.Text = textBox1.Text.Replace(" ", "").Replace("\t", "").Replace("\n", "").Replace("\r", "").Replace("<fontstyle='color:red'>", "").Replace("</font>", "");
        }

        private void button2_Click(object sender, EventArgs e)
        {
            var stringToStrip = textBox1.Text;
            stringToStrip = Regex.Replace(stringToStrip, "</p(?:\\s*)>(?:\\s*)<p(?:\\s*)>", "\n\n", RegexOptions.IgnoreCase | RegexOptions.Compiled);
            stringToStrip = Regex.Replace(stringToStrip, "<[^>]+>", " ", RegexOptions.IgnoreCase | RegexOptions.Compiled);
            textBox1.Text = stringToStrip;
        }

        private void textBox1_DoubleClick(object sender, EventArgs e)
        {
                textBox1.SelectAll();
        }

        private void textBox1_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.A && e.Control)
            {
                textBox1.SelectAll();
            }
        }

    }
}
