﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SafeStreets
{
    //"Pulsante sul menu"
    public class MasterDetailMenuItem
    {
        public MasterDetailMenuItem()
        {
            TargetType = typeof(MasterDetailDetail);
            //TargetType = targetPage;
        }
        public int Id { get; set; }
        public string Title { get; set; }

        public Type TargetType { get; set; }

        public string PaginaDaCreare { get; set; }
    }
}