using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class MasterDetailMaster : ContentPage
    {
        public ListView ListView;

        public MasterDetailMaster()
        {
            InitializeComponent();

            BindingContext = new MasterDetailMasterViewModel();
            ListView = MenuItemsListView;

            xLogoImage.Source = ImageSource.FromResource("SafeStreets._Images.logoMasterDetail.png");
        }

        class MasterDetailMasterViewModel : INotifyPropertyChanged
        {
            public ObservableCollection<MasterDetailMenuItem> MenuItems { get; set; }

            public MasterDetailMasterViewModel()
            {
                //lista dei pulsanti che devo vedere sul menu
                MenuItems = new ObservableCollection<MasterDetailMenuItem>(new[]
                {
                    new MasterDetailMenuItem { Id = 0, Title = "🏠 Report", TargetType = typeof(MasterDetailDetail) },
                    new MasterDetailMenuItem { Id = 1, Title = "🗓️ Past Reports", TargetType = typeof(PastReportsPage) },
                    new MasterDetailMenuItem { Id = 2, Title = "🛣️ Streets Safety", TargetType = typeof(StreetsSafetyMapPage) },
                    new MasterDetailMenuItem { Id = 3, Title = "⚙️ Account Options", TargetType = typeof(OptionsPage) },
                });
            }

            #region INotifyPropertyChanged Implementation
            public event PropertyChangedEventHandler PropertyChanged;
            void OnPropertyChanged([CallerMemberName] string propertyName = "")
            {
                if (PropertyChanged == null)
                    return;

                PropertyChanged.Invoke(this, new PropertyChangedEventArgs(propertyName));
            }
            #endregion
        }
    }
}