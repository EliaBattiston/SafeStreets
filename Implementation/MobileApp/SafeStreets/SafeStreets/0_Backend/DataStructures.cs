using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SafeStreets
{

    public class SimpleCallAnswer
    {
        public bool done { get; set; }
    }

    //Past reports start
    public class PastReport
    {
        public string typology { get; set; }
        public string address { get; set; }
        public string dateTime { get; set; }
    }

    public class PastReportsAnswer
    {
        public bool found { get; set; }
        public List<PastReport> pastReports { get; set; }
    }
    //Past reports end



    /*
     * Tipo di collection utile: ObservableCollection<UserData> x;
     * da quel che ho capito se collegata ad una listview, quest'ultima si aggiorna all'aggiornarsi della collection
     */
    public class SharedStructures
    {

    }

    public static class Constants
    {
        //public static string Username = "Xamarin";
        //public static string Password = "password";
    }

    public class Prerequisiti
    {
        public int app_required_version {get; set;}
    }

    /**
     * classe che contiene i dati del JSON di login
     */
    public class UserData
    {
        public bool loggato { get; set; }
        public string utente { get; set; }
        public string nome { get; set; }
        public string cognome { get; set; }
        public string password { get; set; }
        public string permesso { get; set; }
        public string id_utente { get; set; }
        public int u { get; set; }
        public string ruoli { get; set; }
        public string motivo { get; set; }

        public UserData()
        {

        }

        public UserData(bool loggato, string utente, string nome, string cognome, string password, string permesso, string id_utente, int u, string ruoli, string motivo)
        {
            this.loggato = loggato;
            this.utente = utente;
            this.nome = nome;
            this.cognome = cognome;
            this.password = password;
            this.permesso = permesso;
            this.id_utente = id_utente;
            this.u = u;
            this.ruoli = ruoli;
            this.motivo = motivo;
        }
    }

    /**
     * Classe che contiene l'offerta, associata ad OfferteRoot
     */
    public class Opportunita
    {
        public string data { get; set; }
        public string citta { get; set; }
        public int distanzaMetri { get; set; }      //Dato da GPS
        public string distanzaKm { get; set; }      //Dato da GPS
        public string materia { get; set; }
        public string descrizione { get; set; }
        public string mi_interessa { get; set; }
        public string non_interessa { get; set; }
        public string non_interessa_motivo_giorni { get; set; }
        public string non_interessa_motivo_spost { get; set; }
        public string non_interessa_motivo_materia { get; set; }
    }

    public class OpportunitaRoot
    {
        public string start_url { get; set; }
        public string mio_path { get; set; }
        public string materia1 { get; set; }
        public string materia2 { get; set; }
        public string materia3 { get; set; }
        public bool status { get; set; }
        public List<Opportunita> offerte { get; set; }
    }

    /**
     * Classe che contiene il modulo, associata a ModuliRoot
     */
    public class Modulo
    {
        public string condiviso { get; set; }
        public string nome_famiglia { get; set; }
        public string citta_famiglia { get; set; }
        public string nome_citta_famiglia { get; set; }
        public string idF { get; set; }
        public string ore_disponibili { get; set; }
        public string credito_accumulato { get; set; }
        public string credito_bonus { get; set; }
        public string ore_per_impacchettamento { get; set; }
        public string link_prenota_modulo { get; set; }
        public string id_pacchetto { get; set; }
        public bool flag_rinnovo { get; set; }

        public Modulo(string condiviso, string nome_famiglia, string citta_famiglia, string idF, string ore_disponibili, string credito_accumulato, string credito_bonus, string ore_per_impacchettamento, string link_prenota_modulo, string id_pacchetto, bool flag_rinnovo)
        {
            this.condiviso = condiviso;
            this.nome_famiglia = nome_famiglia;
            this.citta_famiglia = citta_famiglia;
            this.nome_citta_famiglia = nome_famiglia + " (" + citta_famiglia + ")";
            this.idF = idF;
            this.ore_disponibili = ore_disponibili;
            this.credito_accumulato = credito_accumulato;
            this.credito_bonus = credito_bonus;
            this.ore_per_impacchettamento = ore_per_impacchettamento;
            this.link_prenota_modulo = link_prenota_modulo;
            this.id_pacchetto = id_pacchetto;
            this.flag_rinnovo = flag_rinnovo;
        }
    }

    public class ModuliRoot
    {
        public bool status { get; set; }
        public string status_text { get; set; }
        public ObservableCollection<Modulo> moduli { get; set; }
    }

    /**
     * Visualizza i dati di form_new_modulo
     */
    public class DatiPerCompilaModulo
    {
        public string url_invio { get; set; }
        public string idP { get; set; }
        public string calora { get; set; }
        public string nome { get; set; }
        public string cognome { get; set; }
        public string nome_famiglia { get; set; }
        public double ore_prenotabili { get; set; }
        public bool ora_prova_fatta { get; set; }
    }

    /**
     * Risposta ad inserisci modulo
     */
    public class RispostaInserisciModulo
    {
        public bool status { get; set; }
        public string status_msg { get; set; }
        public bool ore_disponibili { get; set; }
        public bool email_sent { get; set; }
        public bool email_user_sent { get; set; }
    }

    /**
     * Risposta per visualizza area prenotazioni
     */
    public class LezioneAreaPrenotazioni
    {
        public bool notifica_sms { get; set; }
        public string notifica_sms_text { get; set; }
        public string nome_famiglia { get; set; }
        public string citta_famiglia { get; set; }
        public string nome_citta_famiglia { get; set; }
        public string giorno { get; set; }
        public string orario { get; set; }
        public string materia { get; set; }
        public bool isOraDiProva { get; set; }
        public string argomento { get; set; }
        public bool modificabile { get; set; }
        public string idM { get; set; }//Id della lezione con M che sta per modulo
        public bool confermabile { get; set; }
        public bool completamento_confermato { get; set; }
        public bool today { get; set; }
        public string status_text { get; set; }
        public string colore_sfondo { get; set; }
        public bool oltreMese { get; set; }

        //public int index { get; set; }

        public LezioneAreaPrenotazioni(bool notifica_sms, string nome_famiglia, string citta_famiglia, string giorno, int giorniDaCompletamentoEConfermato, string orario, string materia, string argomento, bool modificabile, string idM, bool confermabile, bool completamento_confermato, bool today)
        {
            this.notifica_sms = notifica_sms;
            if(notifica_sms)
                this.notifica_sms_text = "Attivata";
            else
                this.notifica_sms_text = "Disattivata";

            this.nome_famiglia = nome_famiglia;
            this.citta_famiglia = citta_famiglia;
            this.nome_citta_famiglia = (completamento_confermato ? "📗 " : (confermabile ? "📘 " : "📙 ")) + "Famiglia: " + nome_famiglia + " (" + citta_famiglia + ")";
            //this.nome_citta_famiglia = (completamento_confermato ? "📗 " : (confermabile ? "📒 " : "📕 ")) + "Famiglia: " + nome_famiglia + " (" + citta_famiglia + ")";

            string nomeGiorno = "";
            string[] data = giorno.Split('-');
            nomeGiorno = (new DateTime(Int32.Parse(data[0]), Int32.Parse(data[1]), Int32.Parse(data[2]))).ToString("dddd");
            //nomeGiorno = nomeGiorno.First().ToString().ToUpper() + input.Substring(1)
            this.giorno = nomeGiorno + " " + giorno;

            this.orario = orario;
            this.materia = materia;
            this.argomento = argomento;
            this.modificabile = modificabile;
            this.idM = idM;
            this.confermabile = confermabile;
            this.completamento_confermato = completamento_confermato;
            this.today = today;

            this.isOraDiProva = (materia == "Ora di prova" ? true : false);

            //Set del testo che si vede in fondo al nodo della lezione
            if (completamento_confermato)
                this.status_text = "Lezione confermata";
            else if (confermabile)
                this.status_text = "Premi per confermare o modificare";
            else if(modificabile)
                this.status_text = "Premi per modificare";
            else
                this.status_text = "Lezione di prova";

            if (today)
                this.colore_sfondo = "LightGreen";
            else
                this.colore_sfondo = "White";

            if (giorniDaCompletamentoEConfermato > 31)
                this.oltreMese = true;
        }
    }

    public class RootElementiAreaPrenotazioni
    {
        public bool presenza_moduli { get; set; }
        public List<string> nomiFamiglie { get; set; }
        public ObservableCollection<LezioneAreaPrenotazioni> lezioni { get; set; }
        public bool cell_confermato { get; set; }
    }

    /**
     * Risposta alla modifica di una lezione
     */
    public class RispostaModLezione
    {
        public bool status { get; set; }
        public string text { get; set; }
    }

    /**
     * Risposta alla conferma di una lezione
     */
    public class RispostaConfermaLezione
    {
        public bool confermato { get; set; }
        public bool error { get; set; }
        public string error_msg { get; set; }
        public bool email_impacchettamento_inviata { get; set; }
    }


    /**
     * Dati per visualizzare l'inserimento delle disponibilità del collaboratore
     */
    public class GiorniDisponibilita
    {
        public string nome_giorno { get; set; }
        public string data { get; set; }
    }

    public class RootGiorniDisponibilita
    {
        public bool error { get; set; }
        public string error_msg { get; set; }
        public string idP { get; set; }
        public string nome_famiglia { get; set; }
        public bool disp_gia_inserite { get; set; } //se si verranno sovrascritte, avviso l'user
        public List<GiorniDisponibilita> giorni { get; set; }
    }
    
    /**
     * Risposta ad inserimento disponibilità
     */
    public class RispostaInsDisponibilita
    {
        public bool error { get; set; }
        public string error_msg { get; set; }
        public bool disponibilita_salvate { get; set; }
        public string url_disponibilita { get; set; }
        public bool modifica { get; set; }
        public bool email_allarme_inviata { get; set; }
        public bool email_avviso_inviata { get; set; }
    }

    public class FAQStructure
    {
        public string id { get; set; }
        public string domanda { get; set; }
        public string risposta { get; set; }
        public string linkStatoUtileSi { get; set; }
        public string linkStatoUtileNo { get; set; }
    }

    /**
     * Dati in risposta dalle API di Google MAPS (key: AIzaSyDCiOfOuRs9zk5oeWCmtUDBgVIiQIKwpCU)
     */
    public class Distance
    {
        public string text { get; set; }
        public int value { get; set; }
    }

    public class Duration
    {
        public string text { get; set; }
        public int value { get; set; }
    }

    public class Element
    {
        public Distance distance { get; set; }
        public Duration duration { get; set; }
        public string status { get; set; }
    }

    public class Row
    {
        public List<Element> elements { get; set; }
    }

    public class GoogleMapsApiAnswer
    {
        public List<string> destination_addresses { get; set; }
        public List<string> origin_addresses { get; set; }
        public List<Row> rows { get; set; }
        public string status { get; set; }
    }
    /**
     * Fine dati MAPS
     */

    //Rendicontazioni
    //public class PacchettoECuboroom
    //{
    //    public string pacchetto { get; set; }
    //}

    public class Pacchetto
    {
        public string nome_famiglia { get; set; }
        public string ore { get; set; }
        public double euro_tot { get; set; }
        public string punti_tot { get; set; }
    }

    public class Cuboroom
    {
        public string cuboroom_nome { get; set; }
        public string cuboroom_data { get; set; }
        public string cuboroom_punti_euro { get; set; }
    }

    public class Rendicontazione
    {
        public string numero { get; set; }
        public string anno { get; set; }
        public string numero_anno { get; set; }
        public bool caricata { get; set; }
        public string data_caricamento { get; set; }
        public string testo_caricamento { get; set; }
        public List<Pacchetto> pacchetti { get; set; }
        public List<Cuboroom> cuborooms { get; set; }
        public string aggiunta_euro { get; set; }
        public string aggiunta_punti { get; set; }
        public string aggiunta_per { get; set; }
        public double totale_euro { get; set; }
        public int totale_punti { get; set; }
        public string link_download_pdf { get; set; }
        public bool firma_caricata { get; set; }
        public bool rendicontazione_scaricata { get; set; }
        public int id { get; set; }
    }

    public class RendicontazioneFirma
    {
        public bool firmato { get; set; }
        public string messaggio { get; set; }
    }
    //fine redndicontazioni

    public class ProfiloUtente
    {
        public string voto { get; set; }
        public string punti_cubo { get; set; }
        public string username { get; set; }
        public string nome { get; set; }
        public string cognome { get; set; }
        public string ruoli { get; set; }//non visualizzato
        public string materie_preferite { get; set; }
        public string livello { get; set; }
        public int num_livello { get; set; }
        public double voti_per_prossimo_livello { get; set; }
        public string prossimo_livello { get; set; }
        /*
        I. da 0 a 7: Livello 0: Tirocinante
        II. da 7 a 10: Livello 1: Apprendista
        III. da 10 a 20: Livello 2: Operativo Junior
        IV. da 21 a 30: Livello 3: Operativo Senior
        V. da 30 a 50: Livello 4: Specialista Junior
        VI. da 50 a 70: Livello 5: Specialista Senior
        VII. da 70 a 100: Livello 6: Professionista
        VIII. da 100 a 140: Livello 7: Professore
        IX. da 140 a 180: Livello 8: Preside
        X. da 180 a 220: Livello 9: Guru del sapere
        XI. da 220 a 250: Livello 10: Mostro Sacro
        XII. da 250 a 300: Livello 11: Divinità delle ripetizioni
        XIII. da 300 a 400: Livello 12: Creatura mitologica della cultura
        XIV. da 400 a 500: Livello 13: Dominatore assoluto della cultura
        XV. da 500 in su: Livello 14: Custode eterno della cultura
        */
    }


    /*Achievements*/
    public class LivelloAchievement
    {
        public int id { get; set; }
        public string titolo { get; set; }
        public int soglia { get; set; }
        public int premio { get; set; }
        public int num_righe { get; set; }
        public bool ritiro_premio { get; set; }
        public int? progressoSingolo { get; set; }
        public string sql { get; set; }
    }

    public class RootAchievement
    {
        public string nomeBloccoAchievement { get; set; } //'tipo' nell'api
        public string tooltip { get; set; }
        public int punteggioAttuale { get; set; } //'progresso' nell'api
        //public List<LivelloAchievement> livello { get; set; } ELABORO I DATI CHE MI SERVONO E NON TENGO GLI ALTRI
        //Creati lato C#
        public int sogliaProssimoLivello { get; set; }
        public string rapportoPunteggi { get; set; } //potremmo chiamarlo progresso
        public string rapportoPunteggiELivello { get; set; }
        public string nomeLivelloAttuale { get; set; }
        public string nomeLivelloSuccessivo { get; set; }
        public int puntiPremio { get; set; }
        public bool visualizzaPuntiPremio { get; set; }
        public bool ritirabile { get; set; }
        public float progressoPercentuale { get; set; }
        public int idAchievement { get; set; }

        public RootAchievement(string tipo, string icona, string tooltip, int progresso, List<LivelloAchievement> livello)
        {
            this.nomeBloccoAchievement = icona + " " + tipo;
            this.tooltip = tooltip;
            this.punteggioAttuale = progresso;
            //this.livello = livello;

            //Inizializzo valori per vista
            int i = 0;
            while(i < livello.Count && livello[i].soglia <= punteggioAttuale)
            {
                i++;
            }

            //controllo se l'utente non è già all'ultimo livello degli achievement
            if(i < livello.Count)
            {
                sogliaProssimoLivello = livello[i].soglia;
                nomeLivelloAttuale = "Livello raggiunto: " + (i > 0 ? (livello[i - 1].titolo + " (" + i + "/" + livello.Count + ")"): "-");
                rapportoPunteggi = punteggioAttuale + "/" + sogliaProssimoLivello;
                rapportoPunteggiELivello = rapportoPunteggi + " " + nomeLivelloAttuale;

                nomeLivelloSuccessivo = "Livello successivo: " + livello[i].titolo;
                puntiPremio = livello[i].premio;
                visualizzaPuntiPremio = true;

                if (i > 0)
                {
                    ritirabile = livello[i - 1].ritiro_premio; //Non è legato al livello a cui ora si sta tentando di arrivare ma al precedente!
                    idAchievement = livello[i - 1].id;
                }
                else
                {
                    ritirabile = false;
                    idAchievement = 0;
                }

                progressoPercentuale = (float)punteggioAttuale / sogliaProssimoLivello;
            }
            else
            {
                sogliaProssimoLivello = 0;
                nomeLivelloAttuale = "Livello raggiunto: " + livello[i - 1].titolo;

                rapportoPunteggi = "" + punteggioAttuale;
                rapportoPunteggiELivello = rapportoPunteggi + " " + nomeLivelloAttuale;

                nomeLivelloSuccessivo = "Livello successivo: - (Raggiunto Livello Massimo)";
                //puntiPremio = livello[i].premio;
                visualizzaPuntiPremio = false;

                //if (i > 0)
                //{
                    ritirabile = livello[i - 1].ritiro_premio; //Non è legato al livello a cui ora si sta tentando di arrivare ma al precedente!
                    idAchievement = livello[i - 1].id;
                //}
                //else
                //{
                //    ritirabile = false;
                //    idAchievement = 0;
                //}

                progressoPercentuale = (float)punteggioAttuale / sogliaProssimoLivello;
            }
            

            
        }
    }

    public class PremioAchievement
    {
        public bool premio_ritirato;
        public int punti_premio;
    }
    /*fine achievements*/
}
