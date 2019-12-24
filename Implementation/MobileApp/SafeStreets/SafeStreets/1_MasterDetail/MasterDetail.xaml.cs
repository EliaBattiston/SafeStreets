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
    public partial class MasterDetail : MasterDetailPage
    {
        public MasterDetail()
        {
            InitializeComponent();
            MasterPage.ListView.ItemSelected += ListView_ItemSelected;
        }

        public Page GetDetail()
        {
            return Detail;
        }

        private async void ListView_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            var item = e.SelectedItem as MasterDetailMenuItem;
            if (item == null)
                return;

            //Visualizzo la loading page e chiudo il menu
            //Detail = new NavigationPage(new LoadingPage());
            IsPresented = false;
            MasterPage.ListView.SelectedItem = null;

            //creo la pagina richiesta
            Page page;
            if (item.TargetType == typeof(MasterDetailDetail))
                page = (Page)Activator.CreateInstance(item.TargetType);
            else
                page = (Page)Activator.CreateInstance(item.TargetType);
            //else if (item.TargetType == typeof(OpportunitaPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await CreateOpportunitaPage());
            //else if (item.TargetType == typeof(PrenotaLezioniPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.GetModuliPrenotaLezioni(App.idU, App.pass));
            //else if (item.TargetType == typeof(AreaPrenotazioniPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.RichiestaDatiConfermaModificaLezioni(App.idU, App.pass));
            //else if (item.TargetType == typeof(RendicontazioniPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.GetRendicontazioni(App.idU, App.pass));
            //else if (item.TargetType == typeof(AchievementsPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.GetAchievements(App.idU, App.pass));
            //else if (item.TargetType == typeof(ProfiloUtentePage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.GetProfiloUtente(App.idU, App.pass));
            //else if (item.TargetType == typeof(FaqListPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType, await JsonRequest.GetFAQ());
            //else if (item.TargetType == typeof(OptionsPage))
            //    page = (Page)Activator.CreateInstance(item.TargetType);
            //else
            //    page = (Page)Activator.CreateInstance(item.TargetType); //MAI DOVREBBE ENTRARE QUI
                
            //page.Title = item.Title;

            //visualizzo la pagina richiesta e chiudo il menu
            Detail = new NavigationPage(page);// { BarBackgroundColor = Color.LimeGreen, BarTextColor = Color.White };
            App.portableDetail = Detail;

            IsPresented = false;
            MasterPage.ListView.SelectedItem = null;
        }

        /*private void OnMenuItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            var item = (MasterPageItem)e.SelectedItem;
            Type page = item.TargetType;
            // Detail = new NavigationPage((Page)Activator.CreateInstance(page));
            Detail.Navigation.PushAsync((Page)Activator.CreateInstance(page));
            IsPresented = false;
        }*/

        private async Task<OpportunitaRoot> CreateOpportunitaPage()
        {
            //OpportunitaRoot offerteToShow = await JsonRequest.GetOpportunita(App.idU, App.pass);

            //offerteToShow = await Shared.calcolaDistanzaOpportunita(offerteToShow);

            //if (App.ordinaPerMateria)
            //    offerteToShow = Shared.ordinaPerMateria(offerteToShow);

            //return offerteToShow;
            return null;
        }
        
    }
}