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

            if(answer.found == true)
            {
                xList.ItemsSource = answer.pastReports;
            }
            else
            {
                string responseString = "{\"found\":true,\"pastReports\":[{\"typology\":\"-\",\"address\":\"-\",\"dateTime\":\"-\"}]}";
                xList.ItemsSource = JsonConvert.DeserializeObject<PastReportsAnswer>(responseString).pastReports;
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