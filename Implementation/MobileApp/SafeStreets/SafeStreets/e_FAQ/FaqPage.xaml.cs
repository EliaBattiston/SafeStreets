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
    public partial class FaqPage : ContentPage
    {
        string linkUtileSi, linkUtileNo;
        public FaqPage(FAQStructure faq)
        {
            InitializeComponent();
            xLabelDomanda.Text = faq.domanda;
            xLabelRisposta.Text = System.Net.WebUtility.HtmlDecode(faq.risposta);
            linkUtileSi = faq.linkStatoUtileSi;
            linkUtileNo = faq.linkStatoUtileNo;
        }

        void OnClickButtonUtilitaSi(object sender, EventArgs e)
        {
            SendUtilita(linkUtileSi);
        }

        void OnClickButtonUtilitaNo(object sender, EventArgs e)
        {
            SendUtilita(linkUtileNo);
        }

        async void SendUtilita(string linkUtile)
        {
            //await Navigation.PushAsync(App.LoadingPage);//Loading page

            string url = JsonRequest.startUrl + linkUtile;
            
            await JsonRequest.CallWebPage(url);

            await DisplayAlert("Grazie", "Grazie per aver inviato il tuo parere", "Continua");

            //RemovePageFromStackSafely(App.LoadingPage);//Togli loading page
        }

        public void RemovePageFromStackSafely(Xamarin.Forms.Page pageToBeRemovedSafely)
        {
            try
            {
                Navigation.RemovePage(pageToBeRemovedSafely);//Togli loading page
            }
            catch (Exception ex)
            {
                ;//Debug.WriteLine("Eccezione: " + ex);
            }
        }

    }
}