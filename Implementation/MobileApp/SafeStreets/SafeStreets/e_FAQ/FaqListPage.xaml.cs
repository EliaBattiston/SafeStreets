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
    public partial class FaqListPage : ContentPage
    {
        public FaqListPage(List<FAQStructure> faqs)
        {
            InitializeComponent();

            xListFaq.ItemsSource = faqs;
        }

        async void OnItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (e.SelectedItem == null) return; // has been set to null, do not 'process' tapped event
            //sotto e.selecteditem ci son tutti i valori che c'eran nell'oggetto da cui è creato!!!! TOP
            ((ListView)sender).SelectedItem = null; // de-select the row

            FAQStructure faq = (FAQStructure)e.SelectedItem;

            await App.portableDetail.Navigation.PushAsync((Page)Activator.CreateInstance(typeof(FaqPage), faq));
        }
    }
}