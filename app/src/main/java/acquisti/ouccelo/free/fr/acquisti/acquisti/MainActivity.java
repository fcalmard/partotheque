package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.GradientDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.AppBarLayout;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutCompat;
import android.support.v7.widget.OrientationHelper;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.util.TypedValue;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import java.util.ArrayList;
import java.util.List;

import static acquisti.ouccelo.free.fr.acquisti.acquisti.MySQLiteHelper.*;


public class MainActivity extends AppCompatActivity
        implements AdapterView.OnItemSelectedListener, NavigationView.OnNavigationItemSelectedListener
{

    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    private boolean bSelectionFamille;
    private ArrayAdapter<Famille> myAdapter;
    private ArrayAdapter<Article> myAdapterArt;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        this.bSelectionFamille=true;

        final Context context = this;

        /*
        selection liste de course
         */

        Spinner spinner_liste = (Spinner) findViewById(R.id.spinner_liste);

        List exemple = new ArrayList();
        exemple.add("ma liste");


		/*Le Spinner a besoin d'un adapter pour sa presentation alors on lui passe le context(this) et
                un fichier de presentation par défaut( android.R.layout.simple_spinner_item)
		Avec la liste des elements (exemple) */
        ArrayAdapter adapter = new ArrayAdapter(
                this,
                android.R.layout.simple_spinner_item,
                exemple
        );

                /* On definit une présentation du spinner quand il est déroulé         (android.R.layout.simple_spinner_dropdown_item) */
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        //Enfin on passe l'adapter au Spinner et c'est tout
        spinner_liste.setAdapter(adapter);

        //TODO initialisation base de données
        /*
        selection famille
         */
        Spinner spinner_famille = (Spinner) findViewById(R.id.spinner_famille);

       List familles = new ArrayList();
       /*
        familles.add("famille1");
        familles.add("famille2");
        familles.add("famille3");*/

		/*Le Spinner a besoin d'un adapter pour sa presentation alors on lui passe le context(this) et
                un fichier de presentation par défaut( android.R.layout.simple_spinner_item)
		Avec la liste des elements (exemple) */
        ArrayAdapter adapterfamilles = new ArrayAdapter(
                this,
                android.R.layout.simple_spinner_item,
                familles
        );

                /* On definit une présentation du spinner quand il est déroulé         (android.R.layout.simple_spinner_dropdown_item) */

        adapterfamilles.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        spinner_famille.setAdapter(adapterfamilles);

        ParamDataSource dtsparam = new ParamDataSource(context);
        dtsparam.open();

        MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);

        /*
        Param nParam=new Param();
        Param oParam=mysqlhlpr.MiseAJourParam(context,dtsparam.getDatabase(),true,MySQLiteHelper.PARAM_MAJ_MODEENCOURS,nParam);
        String modeEnCours= oParam.getModeencours();

        boolean modeachat=modeEnCours.equals(PARAM_MODEENCOURS_ACHAT);

        //ACTIVATION MODE CTRL MODE ACHAT
        final ImageButton btnactmodectrl = (ImageButton) findViewById(R.id.BtnActiverModeCtrl);




*/
        dtsparam.close();

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();

        //Log.v("MAIN ONCREATE","157");

    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.init_bd) {
            /*
            init base de données
             */
            final Intent intent = new Intent(MainActivity.this, initbd.class);
            startActivity(intent);
        } else if (id == R.id.gestarticles) {
            /*
            articles
             */
            final Intent intent = new Intent(MainActivity.this, Articles.class);
            startActivity(intent);
        } else if (id == R.id.gestfamilles) {
            /*
            familles
             */
            final Intent intent = new Intent(MainActivity.this, Familles.class);
            startActivity(intent);



        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    public void Close(View View) {

        final Context context = this;

        AlertDialog.Builder adb = new AlertDialog.Builder(context);

        adb.setIcon(android.R.drawable.ic_dialog_alert);

        int s = R.string.msgquit;

        adb.setTitle(s);

        adb.setPositiveButton("Ok", null);

        adb.setPositiveButton(R.string.yes, new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int which) {

                finish();
            }

        });

        adb.setNegativeButton(R.string.no, null);

        adb.setMessage(s);

        adb.show();

    }

    @Override
    public void onStart() {
        super.onStart();
        //Log.v("MAIN ON START","ONSTART 266");

        /* on récupère les familles */

        FamillesDataSource datasourcefam = new FamillesDataSource(this);
        datasourcefam.open();
        List<Famille> listValues = datasourcefam.getAllFamilles(true);
        myAdapter = new ArrayAdapter<Famille>(this, R.layout.row_layout_fam,
                R.id.listText, listValues);
        //
        Spinner spinner_famille = (Spinner) findViewById(R.id.spinner_famille);

        spinner_famille.setAdapter(myAdapter);
        spinner_famille.setOnItemSelectedListener(this);

        ParamDataSource dtsparam = new ParamDataSource(this);
        dtsparam.open();

        MySQLiteHelper mysqlhlpr=new MySQLiteHelper(this);

        //Log.v("MAIN ONSTART","280***");

        int nversion=mysqlhlpr.ControleVersionBaseDeDonnees(this,dtsparam.getDatabase());

        //Log.v("MAIN ONSTART","285 NVERSION="+nversion);

        //nversion++;

        //mysqlhlpr.majBaseDeDonnees(this,dtsparam.getDatabase(),nversion);

        //Log.v("MAIN ONSTART","291 NVERSION="+nversion);

        /*
        ParamDataSource dtsparam = new ParamDataSource(context);
        dtsparam.open();

        MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);

         */

        Param nParam=new Param();

        String modeEnCours= MySQLiteHelper.PARAM_MODEENCOURS_LISTE;

        //Param oParam= mysqlhlpr.MiseAJourParam(this,dtsparam.getDatabase(),false,0,nParam);
        Long lidfamille=Long.valueOf(0);

        Param oParam= mysqlhlpr.LectureParam(this,dtsparam.getDatabase());

        lidfamille=oParam.getFamilleEnCours();

        //oParam= mysqlhlpr.MiseAJourParam(this,dtsparam.getDatabase(),false,0,nParam);

        //Log.v("MAIN ONSTART","305");

        modeEnCours=oParam.getModeencours();

       //Log.d("ON START ","326,MODE EN COURS >"+modeEnCours+"<");

        final ImageButton btnmode = (ImageButton) findViewById(R.id.imageBtnMode);

        boolean modeliste=modeEnCours.equals(PARAM_MODEENCOURS_LISTE);

       //Log.d("MAIN ACTIVITY ", "332, LECTURE MODE EN COURS >" + modeEnCours + "< modeliste=" + modeliste);

        //ACTIVATION MODE CTRL MODE ACHAT
        final ImageButton btnactmodectrl = (ImageButton) findViewById(R.id.BtnActiverModeCtrl);

        if (modeliste)
        {
            //btnactmodectrl.setVisibility(0);
            btnmode.setBackgroundResource(R.drawable.liste2);
           //Log.v("MAIN ONSTART","341 "+modeEnCours);

        }else
        {
            //btnactmodectrl.setVisibility(1);
            btnmode.setBackgroundResource(R.drawable.caddy);
           //Log.v("MAIN ONSTART","347 "+modeEnCours);
        }

        final ImageButton imageBtnActiverModeCtrl = (ImageButton) findViewById(R.id.BtnActiverModeCtrl);

        /*
        boolean bCtrlActive=oParam.getBmodectrl();
        if (bCtrlActive)
        {

            btnmode.setBackgroundResource(R.drawable.controleb);

        }else
        {
            btnmode.setBackgroundResource(R.drawable.liste);
        }
        */

        /*
        chargement liste des articles
         */

        //Log.v("MAIN ONSTART","358");


        //spinner_famille.setSelection(lidfamille.intValue());
        //lidfamille=spinner_famille.getSelectedItemId();

        //Log.v("MAIN ONSTART","362");

        //MiseAJourParam
        //mysqlhlpr.MiseAJourParam(this,dtsparam.getDatabase(),false,0,nParam);

        /*
        Param oParam= mysqlhlpr.MiseAJourParam(this,dtsparam.getDatabase(),false,0,nParam);

        if(oParam !=null)
        {
            lidfamille=oParam.getFamilleEnCours();

           //Log.d("MAIN ACTIVITY","373 LIDFAMILLE="+lidfamille.toString());

            //FamillesDataSource dtsfam = new FamillesDataSource(this);
            //dtsfam.open();
            //
            //dtsfam.close();
            //

        }
        */

        spinner_famille.setSelection(lidfamille.intValue(),true);

        this.AfficheArticles(lidfamille);

        //Log.v("MAIN ONSTART","378");

        //Log.v("MAIN","FIN TRAITEMENT MAJ STRUCTURE DATABASE >"+nversion+"<");

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main Page", // TODO: Define a title for the content shotn.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://acquisti.ouccelo.free.fr.acquisti.acquisti/http/host/path")
        );
        AppIndex.AppIndexApi.start(client, viewAction);

        datasourcefam.close();

        dtsparam.close();

        //Log.v("MAIN ONSTART","388");

    }

    private void AfficheArticles(long idfamille)
    {
        final Context context = this;

        AppBarLayout.LayoutParams lp1 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.MATCH_PARENT,
                DrawerLayout.LayoutParams.MATCH_PARENT);

        AppBarLayout.LayoutParams lp2 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.WRAP_CONTENT,
                DrawerLayout.LayoutParams.WRAP_CONTENT);

        AppBarLayout.LayoutParams lp3 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.MATCH_PARENT,
                DrawerLayout.LayoutParams.WRAP_CONTENT);

        AppBarLayout.LayoutParams lpfill = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.FILL_PARENT,
                DrawerLayout.LayoutParams.FILL_PARENT);

        ArticleDataSource datasourceart = new ArticleDataSource(this);
        datasourceart.open();

        Param nParam=new Param();

        MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);

        ParamDataSource dtsparam = new ParamDataSource(context);
        dtsparam.open();

        nParam=dtsparam.LectureParam();
        String modeEnCours=nParam.getModeencours();

       //Log.v("MAIN","455 modeencours >"+modeEnCours);

        //Param oParam=mysqlhlpr.MiseAJourParam(context,dtsparam.getDatabase(),false,MySQLiteHelper.PARAM_MAJ_CTRLMODE,nParam);

        List<Article> listValuesArt = datasourceart.getAllArticles(idfamille);

        myAdapterArt = new ArrayAdapter<Article>(this, R.layout.row_layout_article,
                R.id.listText, listValuesArt);

        final LinearLayout LinearLayoutlisteproduits = (LinearLayout) findViewById(R.id.idlisteproduits);

        LinearLayoutlisteproduits.removeAllViewsInLayout();

        LinearLayoutlisteproduits.setBackgroundColor(Color.LTGRAY);

        final LinearLayout gabaritListeDet = new LinearLayout (this);
        gabaritListeDet. setGravity(Gravity.LEFT);

        gabaritListeDet.setOrientation(LinearLayout.VERTICAL);

        gabaritListeDet.removeAllViewsInLayout();

        gabaritListeDet.setPadding(25,25,0,0);

        //String modeEnCours = MySQLiteHelper.PARAM_MODEENCOURS_LISTE;//                oParam.getModeencours();

        boolean bmodeliste=modeEnCours.equals(PARAM_MODEENCOURS_LISTE);

        //famille selectionnees
        int ifamsel = 0;// oParam.

        int iart=0;

        for (Article art : listValuesArt)
        {
            LinearLayout gabaritDet = new LinearLayout (this);

            gabaritDet.setVerticalScrollBarEnabled(true);
            iart++;

            final ImageButton btnach= new ImageButton(context);

            btnach.setId(iart);

            btnach.setTag(art);

            btnach.setOnClickListener(new View.OnClickListener() {

                //int idbtn=btnach.getId();

                @Override
                public void onClick(View view)
                {

                //final Context context = view.getContext();

                //AlertDialog.Builder adb = new AlertDialog.Builder(context);

                //adb.setTitle(dlgslib);

                int id=view.getId();

                Article art = (Article) view.getTag();

                    majArticle(art);

                //Log.v("ONCLICK",art.toString());

                finish();
                startActivity(getIntent());

                }
            });


            gabaritDet.setLayoutParams(lp3);

            gabaritDet.setOrientation(LinearLayout.HORIZONTAL);

            gabaritDet. setGravity(Gravity.LEFT|Gravity.START);

            gabaritDet.setClickable(true);

            TextView texttv = new TextView(context);

            texttv.setText(art.getLibelle());

           //Log.v("COMPTEUR ", String.valueOf(Integer.valueOf(iart)));

            texttv.setHeight(100);

            texttv.setTextSize(TypedValue.COMPLEX_UNIT_PX, 40);

            //texttv.setTextSize(500,40);
            //setFont(textView3,"CURSTOM-FONT2.ttf");
            texttv.setTextColor(Color.BLUE);

           // setFont(texttv,"Roboto-Light.ttf");
            setFont(texttv,"RobotoCondensed-Bold.ttf");
           // setFont(texttv,"Roboto-Italic.ttf");

            int w=700;
            //OrientationHelper.HORIZONTAL

            int oi = getResources().getConfiguration().orientation ;
            //Log.v("MAIN ACTIVITY","Portrait-517 OI="+oi);

            if (oi == 1)
            {
                w=400;//portrait
            }
            else
            {
                if (oi == 2)
                {
                    w=700;//paysage
                }
            }

            //libelle produit

            texttv.setWidth(w);

            gabaritDet.addView(texttv);

            /*
            tester statut dans liste ou achat en fonction du mode
             */
            if(bmodeliste)
            {
                btnach.setImageResource(R.drawable.ajout2);
                //Log.v("MAIN ACTIVITY","MODE 586 "+MySQLiteHelper.PARAM_MODEENCOURS_LISTE);


            }else{
                btnach.setImageResource(R.drawable.caddy);
                //Log.v("MAIN ACTIVITY","MODE 591 "+MySQLiteHelper.PARAM_MODEENCOURS_ACHAT);
            }
            gabaritDet.addView(btnach);

           // gabaritDet.setPadding(10,10,10,10);

            gabaritDet.setLayoutParams(lp2);

            gabaritDet.setMinimumWidth(500);

            gabaritDet.setMinimumHeight(100);

            gabaritListeDet.addView(gabaritDet);

        }

        //Log.v("MAIN","560");

        LinearLayoutlisteproduits.addView(gabaritListeDet);

        LinearLayoutlisteproduits.setScrollContainer(true);

        //Log.v("MAIN","566");

        // LinearLayoutlisteproduits.setLayoutParams(lpfill);
       //wrap content height LinearLayoutlisteproduits.setLayoutParams(lp3);


        final ImageButton imagebuttonMode = (ImageButton) findViewById(R.id.imageBtnMode);

        imagebuttonMode.setOnClickListener(new View.OnClickListener() {

            //int idbtn=btnach.getId();

            @Override
            public void onClick(View view)
            {

                final Context context = view.getContext();

                ParamDataSource dtsparam = new ParamDataSource(context);

                dtsparam.open();

                MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);

                Param nParam=dtsparam.LectureParam();

                String modeEnCours=nParam.getModeencours();
               //Log.v("MAINACTIVITY","644 "+nParam.getModeencours());

                boolean modeliste=modeEnCours.equals(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                if(modeliste)
                {
                    nParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_ACHAT);
                    //Toast.makeText(MainActivity.this, " 647 getModeencours= "+nParam.getModeencours(), Toast.LENGTH_LONG).show();
                   //Log.v("MAINACTIVITY","652 PASSAGEENMODEACHAT"+nParam.getModeencours());

                }else
                {
                    nParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);
                   //Log.v("MAINACTIVITY","657 PASSAGEENMODELISTE"+nParam.getModeencours());
                    //Toast.makeText(MainActivity.this, " 652 getModeencours= "+nParam.getModeencours(), Toast.LENGTH_LONG).show();
                }

                boolean bmaj=mysqlhlpr.MiseAJourParam2(context,dtsparam.getDatabase(),true,MySQLiteHelper.PARAM_MAJ_MODEENCOURS,nParam);
                if(bmaj)
                {

                    //dtsparam.LectureParam();

                    //
                    //
                    //Toast.makeText(MainActivity.this, " PARAMETRES MISE A JOUR getModeencours= "+nParam.getModeencours(), Toast.LENGTH_LONG).show();

                }
//

                //Toast.makeText(MainActivity.this, " BUTTON MODE ", Toast.LENGTH_LONG).show();

                //Log.v("MAIN ACT","621");

               // Param oParam=mysqlhlpr.MiseAJourParam(context,dtsparam.getDatabase(),true,MySQLiteHelper.PARAM_MAJ_MODEENCOURS,nParam);

               // Log.v("MAIN ACT","625 OPARAM="+oParam.toString());



                //String modeEnCours=MySQLiteHelper.PARAM_MODEENCOURS_LISTE;//oParam.getModeencours();

                //Param oParam=mysqlhlpr.MiseAJourParam(context,dtsparam.getDatabase(),false,MySQLiteHelper.PARAM_MAJ_CTRLMODE,nParam);


                //String modeEnCours=oParam.getModeencours();

                //Log.v("MAIN ACT","629 >"+modeEnCours+"<");

                //boolean modeachat=modeEnCours.equals(PARAM_MODEENCOURS_ACHAT);

               //Log.v("MAIN ACT","550");

                // boolean modeliste=modeEnCours.equals(PARAM_MODEENCOURS_LISTE);

                //Log.d("MAIN ACTIVITY CLICK", "LECTURE MODE EN COURS >" + modeEnCours + "< resultOfComparison=" + modeliste);


                //mysqlhlpr.ControleVersionBaseDeDonnees(context,dtsparam.getDatabase());

                //Log.v("MAIN","FIN TRAITEMENT VERSIONDATABASE >"+nversion+"<");

                //ACTIVATION MODE CTRL MODE ACHAT

                dtsparam.close();

                finish();

                startActivity(getIntent());

            }
        });

        final ImageButton imageBtnActiverModeCtrl = (ImageButton) findViewById(R.id.imageBtnActiverModeCtrl    );

        if (bmodeliste)
        {
         //Log.v("MAIN ACT","702 MODE LISTE "+MySQLiteHelper.PARAM_MODEENCOURS_LISTE);
            //btnactmodectrl.setVisibility(0);
            imagebuttonMode.setBackgroundResource(R.drawable.liste2);
        }else
        {
          //Log.v("MAIN ACT","707 MODE ACHAT "+MySQLiteHelper.PARAM_MODEENCOURS_ACHAT);
            //btnactmodectrl.setVisibility(1);
            imagebuttonMode.setBackgroundResource(R.drawable.caddy);
        }
        //Log.v("MAIN ACT","711");

        boolean ctrlact=false;//oParam.getBmodectrl();
        if(ctrlact)
        {
            //imageBtnActiverModeCtrl.setBackgroundResource(R.drawable.checklist2);

        }else
        {
            //imageBtnActiverModeCtrl.setBackgroundResource(R.drawable.controleb);

        }
        //Log.v("MAIN ACT","723");
        //String modeEnCours=oParam.getModeencours();
        boolean modeachat=modeEnCours.equals(PARAM_MODEENCOURS_ACHAT);
        //Log.v("MAIN ACT","726");

        final ImageButton btnactmodectrl = (ImageButton) findViewById(R.id.BtnActiverModeCtrl);
        //Log.v("MAIN ACT","729");

        if(modeachat)
        {
            imageBtnActiverModeCtrl.setVisibility(View.VISIBLE);

        }else
        {
            imageBtnActiverModeCtrl.setVisibility(View.GONE);
        }
        //Log.v("MAIN ACT","739");

        dtsparam.close();

       // btnactmodectrl.setVisibility(modeachat);

        //Log.v("MAIN","704 MODEENCOURS>"+modeEnCours+"<");

        imageBtnActiverModeCtrl.setOnClickListener(new View.OnClickListener() {

            //int idbtn=btnach.getId();

            @Override
            public void onClick(View view)
            {

                final Context context = view.getContext();


                ParamDataSource dtsparam = new ParamDataSource(context);
                dtsparam.open();

                MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);

                Param nParam=new Param();

                //Param oParam=mysqlhlpr.MiseAJourParam(context,dtsparam.getDatabase(),true,MySQLiteHelper.PARAM_MAJ_CTRLMODE,nParam);
                //boolean ctrlact=oParam.getBmodectrl();

                //view.


                //Log.d("MAIN ACTIVITY CLICK", "LECTURE MODE EN COURS >" + modeEnCours + "< resultOfComparison=" + modeliste);


                //mysqlhlpr.ControleVersionBaseDeDonnees(context,dtsparam.getDatabase());

                //Log.v("MAIN","FIN TRAITEMENT VERSIONDATABASE >"+nversion+"<");


                dtsparam.close();


                finish();

                startActivity(getIntent());

            }
        });

        Toast.makeText(MainActivity.this, " Fin Affichage Articles FAMILLE="+idfamille+" MODE="+modeEnCours, Toast.LENGTH_SHORT).show();

    }

    public void majArticle(Article art)
    {
/*
    public static final String COLUMN_DSLISTE = "idliste";// SI MODE LISTE INTEGER OU IDENTIFIANT LISTE SELECTIONEE OUI 1 0
    public static final String COLUMN_DSACHATS = "dsachats";// SI MODE ACHAT INTEGER OUI O 10
 */
    }

    public void setFont(TextView textView, String fontName) {
        if(fontName != null){
            try {
                Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/" + fontName);
                textView.setTypeface(typeface);
            } catch (Exception e) {
                Log.e("FONT", fontName + " not found", e);
            }
        }

    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://acquisti.ouccelo.free.fr.acquisti.acquisti/http/host/path")
        );
        AppIndex.AppIndexApi.end(client, viewAction);
        client.disconnect();
    }

    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {


        if(view !=null && this.bSelectionFamille)
        {
            //Log.v("MAIN ONITEMSELECTED","798");
            Integer idview = view.getId();
            //Log.v("MAIN ONITEMSELECTED","800");
            //if(idview==R.id.spinner_famille)

            //Log.v("MAINACT","750 ");

            Spinner spinner_famille = (Spinner) findViewById(R.id.spinner_famille);

            Long lidfamille=spinner_famille.getSelectedItemId();

            //spinner_famille.getAdapter().getItem(1);

            //Log.v("MAINACT","861 IDFAMILLE="+lidfamille.toString());

            if(lidfamille!=-1)
            {

                MySQLiteHelper mysqlhlpr=new MySQLiteHelper(this);

                //Param nParam=new Param();



                //Log.v("MAINACT","824 IDFAMILLE="+lidfamille.toString()+" NPARAM="+nParam.toString());

                ParamDataSource dtsparam = new ParamDataSource(this);
                dtsparam.open();

                Param nParam=dtsparam.LectureParam();

                nParam.setFamilleEnCours(lidfamille);

                //MiseAJourParam(Context context,SQLiteDatabase db,boolean bMaj,int iTypeMaj,Param oParam)
                final Context context = this;

                //mysqlhlpr.majBaseDeDonnees(context,true,dtsparam.getDatabase(), MySQLiteHelper.PARAM_MAJ_FAMENCOURS,nParam);

                boolean bmaj=false;

/**/
                bmaj=mysqlhlpr.MiseAJourParam2(context,dtsparam.getDatabase(),true,MySQLiteHelper.PARAM_MAJ_FAMENCOURS,nParam);
                if(bmaj)
                {

//                    Toast.makeText(MainActivity.this, " PARAMETRES MISE A JOUR getFamilleEnCours= "+nParam.getFamilleEnCours(), Toast.LENGTH_LONG).show();
//                    Toast.makeText(MainActivity.this, " PARAMETRES MISE A JOUR lidfamille= "+lidfamille, Toast.LENGTH_LONG).show();

                }
                /**/

                dtsparam.close();

                if(lidfamille!=0)
                {

                    long ifam=spinner_famille.getSelectedItemId();

                    String slibfam;
                    Famille famensel= (Famille) spinner_famille.getAdapter().getItem((int)ifam);

                    slibfam=famensel.getLibelle();

                    //Toast.makeText(MainActivity.this, " FAMILLE SELECTIONNEE="+lidfamille+" GETITEM="+slibfam, Toast.LENGTH_LONG).show();

                }

                AfficheArticles(lidfamille);

            }


        }


        this.bSelectionFamille=true;


    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {
        Log.v("MAIN ACT 942"," ON NOTHING SELECTED");

    }
}
