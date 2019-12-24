using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class PastReportDetailPage : ContentPage
	{
		public PastReportDetailPage (PastReport report)
		{
			InitializeComponent ();

            xTypologyLabel.Text = report.typology;
            xAddressLabel.Text = report.address;
            xDateTimeLabel.Text = report.dateTime;
		}

        //tolbar closeModal button handler
        async void OnCloseModalClicked(object sender, System.EventArgs e)
        {
            await Navigation.PopModalAsync();
        }

    }
}