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
	public partial class RestoreCredentialsPage : ContentPage
	{
		public RestoreCredentialsPage ()
		{
			InitializeComponent ();
		}

        private async void OnRestoreClicked(object sender, EventArgs e)
        {
            string user = xUsernameEntry.Text;

            if (Utils.HasText(user))
            {
                SimpleCallAnswer answer = await JsonRequest.RestoreCredentials(user);

                if(answer != null)
                {
                    if (answer.result == 200)
                        await DisplayAlert("Restored!", "A restore procedure has been sent to your email address", "Ok");
                    else
                        await DisplayAlert("Error!", answer.message, "Ok");
                }
                else
                    await DisplayAlert("Error!", "The restore procedure cannot be done.", "Ok");
            }
            else
            {
                await DisplayAlert("Attention!", "Insert a valid username to continue.", "Ok");
            }
        }

        //tolbar closeModal button handler
        async void OnCloseModalClicked(object sender, System.EventArgs e)
        {
            await Navigation.PopModalAsync();
        }
    }
}