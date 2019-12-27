using Newtonsoft.Json;
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
	public partial class PastReportsPage : ContentPage
	{
		public PastReportsPage ()
		{
			InitializeComponent ();

            LoadPastReports();
        }

        async void LoadPastReports()
        {
            PastReportsAnswer answer = await JsonRequest.LoadOldReports();

            if(answer.result == 200)
            {
                xList.ItemsSource = answer.content;
            }
            else
            {
                string responseString = "{ \"result\":400,\"content\": [{ \"username\":\"-\", \"firstName\":\"-\", \"lastName\":\"-\",\"reportID\":-1,\"timestamp\":\"2000-01-01 00:00:01\",\"address\":\"address\", \"licensePlate\":\"AA000AA\", \"violation\":\"none\", \"notes\":\"notes\" } ]}";
                xList.ItemsSource = JsonConvert.DeserializeObject<PastReportsAnswer>(responseString).content;
            }
        }

        async void OnItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (e.SelectedItem == null) return; // has been set to null, do not 'process' tapped event
            //sotto e.selecteditem ci son tutti i valori che c'eran nell'oggetto da cui è creato!!!! TOP
            ((ListView)sender).SelectedItem = null; // de-select the row

            PastReport report = (PastReport)e.SelectedItem;

            await Navigation.PushModalAsync(new NavigationPage(new PastReportDetailPage(report)) { BarTextColor = Color.White });
        }
    }
}