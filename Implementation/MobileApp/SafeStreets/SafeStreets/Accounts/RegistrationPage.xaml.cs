using System;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class RegistrationPage : ContentPage
	{
		public RegistrationPage ()
		{
			InitializeComponent ();
		}

        private async void OnSignUpClicked(object sender, EventArgs e)
        {
            string email, username, firstName, lastName, fiscalCode;

            email = xEmailEntry.Text;
            username = xUsernameEntry.Text;
            firstName = xFirstNameEntry.Text;
            lastName = xLastNameEntry.Text;
            fiscalCode = xFiscalCodeEntry.Text;

            if(email != string.Empty && username != string.Empty && firstName != string.Empty && lastName != string.Empty && fiscalCode != string.Empty)
            {
                SimpleCallAnswer answer = await JsonRequest.Registration(email, username, firstName, lastName, fiscalCode);

                if (answer!=null && answer.done)
                {
                    await DisplayAlert("Done!", "The registration has been done!", "Ok");
                    await Navigation.PopModalAsync();
                }
                else
                {
                    await DisplayAlert("Error!", "An error occurred during your registration!", "Ok");
                }
            }
            else
            {
                await DisplayAlert("Missing data!", "All the entries are required in order to register!", "Ok");
            }
        }

        //tolbar closeModal button handler
        async void OnCloseModalClicked(object sender, System.EventArgs e)
        {
            await Navigation.PopModalAsync();
        }
    }
}