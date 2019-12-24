using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class LoadingPage : ContentPage
	{
        public LoadingPage()
        {
            InitializeComponent();

            NavigationPage.SetHasBackButton(this, false);
        }

        //public LoadingPage(Type pageType)
        //{
        //    InitializeComponent();

        //    NavigationPage.SetHasBackButton(this, false);

        //    createPage(pageType);
        //}

        //private async void createPage(Type pageType)
        //{
        //    Page page;
        //    if (pageType == typeof(OpportunitaPage))
        //    {
        //        page = (Page)Activator.CreateInstance(pageType, await CreateOpportunitaPage());
        //    }
        //    //MasterDetailPage
        //}

        //private async Task<OpportunitaRoot> CreateOpportunitaPage()
        //{
        //    OpportunitaRoot offerteToShow = await JsonRequest.GetOpportunita(App.idU, App.pass);

        //    offerteToShow = await Shared.calcolaDistanzaOpportunita(offerteToShow);

        //    if (App.ordinaPerMateria)
        //        offerteToShow = Shared.ordinaPerMateria(offerteToShow);

        //    return offerteToShow;
        //}
    }
}