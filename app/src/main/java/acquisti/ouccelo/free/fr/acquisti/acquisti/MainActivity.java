package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.AppBarLayout;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
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
import android.widget.Spinner;
import android.widget.TextView;

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

    private ArrayAdapter<Famille> myAdapter;
    private ArrayAdapter<Article> myAdapterArt;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        final Context context = this;

        /*FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });*/
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

        String modeEnCours= mysqlhlpr.ModeEnCours(context,dtsparam.getDatabase(),false);

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

        dtsparam.close();
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

        int nversion=mysqlhlpr.ControleVersionBaseDeDonnees(this,dtsparam.getDatabase());

        //Log.v("MAIN","FIN TRAITEMENT VERSIONDATABASE >"+nversion+"<");

        nversion++;

        mysqlhlpr.majBaseDeDonnees(this,dtsparam.getDatabase(),nversion);

        /*
        ParamDataSource dtsparam = new ParamDataSource(context);
        dtsparam.open();

        MySQLiteHelper mysqlhlpr=new MySQLiteHelper(context);
         */

        String modeEnCours= mysqlhlpr.ModeEnCours(this,dtsparam.getDatabase(),false);

        //Log.d("ON START ","MODE EN COURS >"+modeEnCours+"<");

        final ImageButton btnmode = (ImageButton) findViewById(R.id.imageBtnMode);

        boolean modeliste=modeEnCours.equals(PARAM_MODEENCOURS_LISTE);

        //Log.d("MAIN ACTIVITY ", "LECTURE MODE EN COURS >" + modeEnCours + "< resultOfComparison=" + modeliste);


        if (modeliste)
        {

            btnmode.setBackgroundResource(R.drawable.liste);

        }else
        {
            btnmode.setBackgroundResource(R.drawable.caddy);
        }

        /*
        chargement liste des articles
         */
        this.AfficheArticles(0);

      //  Log.v("MAIN","FIN TRAITEMENT MAJ STRUCTURE DATABASE >"+nversion+"<");

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
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
        AppIndex.AppIndexApi.start(client, viewAction);

        datasourcefam.close();

        dtsparam.close();
    }

    private void AfficheArticles(long idfamille)
    {


        AppBarLayout.LayoutParams lp1 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.MATCH_PARENT,
                DrawerLayout.LayoutParams.MATCH_PARENT);

        AppBarLayout.LayoutParams lp2 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.WRAP_CONTENT,
                DrawerLayout.LayoutParams.WRAP_CONTENT);

        AppBarLayout.LayoutParams lp3 = new AppBarLayout.LayoutParams(DrawerLayout.LayoutParams.MATCH_PARENT,
                DrawerLayout.LayoutParams.WRAP_CONTENT);

        ArticleDataSource datasourceart = new ArticleDataSource(this);
        datasourceart.open();

        List<Article> listValuesArt = datasourceart.getAllArticles(idfamille);

        myAdapterArt = new ArrayAdapter<Article>(this, R.layout.row_layout_article,
                R.id.listText, listValuesArt);

        final LinearLayout LinearLayoutlisteproduits = (LinearLayout) findViewById(R.id.idlisteproduits);

        LinearLayoutlisteproduits.removeAllViewsInLayout();

        LinearLayoutlisteproduits.setBackgroundColor(Color.LTGRAY);

        final LinearLayout gabaritListeDet = new LinearLayout (this);
        gabaritListeDet. setGravity(Gravity.LEFT);
        //LayoutParams.FILL_PARENT WRAP_CONTENT

        gabaritListeDet.setOrientation(LinearLayout.VERTICAL);

        gabaritListeDet.removeAllViewsInLayout();

        gabaritListeDet.setPadding(25,25,0,0);


        int iart=0;

        for (Article art : listValuesArt)
        {
            LinearLayout gabaritDet = new LinearLayout (this);

            iart++;

            final Context context = this;

            final ImageButton btnach= new ImageButton(context);

            //String sid;

           // sid = String.valueOf(art.getId());

            btnach.setId(iart);

            btnach.setTag(art);


            btnach.setOnClickListener(new View.OnClickListener() {

                //int idbtn=btnach.getId();

                @Override
                public void onClick(View view)
                {

                    final Context context = view.getContext();

                    //AlertDialog.Builder adb = new AlertDialog.Builder(context);

                    //adb.setTitle(dlgslib);

                    int id=view.getId();

                    Article art = (Article) view.getTag();

                    Log.v("ONCLICK",art.toString());

                    //adb.setPositiveButton("Ok", null);

                    //View idv = findViewById(R.id.txtid);

                    // tv = new TextView();

                    //TextView tv = (TextView) findViewById(R.id.txtid);
                    //AchatBDD locmbd= new AchatBDD(context);

                    /*

                    //int iv=idv.getId();
                    Boolean res=locmbd.MajListeAchat((long) id,argmode);


                    String msgctrl="pas ok";
                    if(res)
                    {
                        msgctrl="ok ";
                    }
                    String s=" id achat = "+String.valueOf(id)+" " + argmode;

                    Log.d("**************** CONTROLE ", msgctrl);
                    Log.d("**************** trace", s);

                    */

                    //int i=tv.getId();

                    //adb.setMessage(msgctrl);


                    finish();
                    startActivity(getIntent());


                }
            });


            gabaritDet.setLayoutParams(lp3);

            gabaritDet.setOrientation(LinearLayout.HORIZONTAL);

            gabaritDet. setGravity(Gravity.LEFT|Gravity.START);

            gabaritDet.setClickable(false);

            TextView texttv = new TextView(context);

            texttv.setText(art.getLibelle());

           // Log.v("COMPTEUR ", String.valueOf(Integer.valueOf(iart)));

            texttv.setHeight(100);

            texttv.setTextSize(TypedValue.COMPLEX_UNIT_PX, 60);

            //texttv.setTextSize(500,40);
            //setFont(textView3,"CURSTOM-FONT2.ttf");
            texttv.setTextColor(Color.BLUE);

           // setFont(texttv,"Roboto-Light.ttf");
            setFont(texttv,"RobotoCondensed-Bold.ttf");
           // setFont(texttv,"Roboto-Italic.ttf");

            //texttv.setFontFeatureSettings();

            texttv.setWidth(500);

            //libelle produit
            gabaritDet.addView(texttv);

            /*
            tester statut dans liste ou achat en fonction du mode
             */
            btnach.setImageResource(R.drawable.liste);
           // btnach.setImageResource(R.drawable.caddy);

            gabaritDet.addView(btnach);

           // gabaritDet.setPadding(10,10,10,10);

            gabaritDet.setLayoutParams(lp2);

            gabaritDet.setMinimumWidth(500);



            gabaritListeDet.addView(gabaritDet);


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

                    String modeEnCours= mysqlhlpr.ModeEnCours(context,dtsparam.getDatabase(),true);

                    boolean modeliste=modeEnCours.equals(PARAM_MODEENCOURS_LISTE);

                    //Log.d("MAIN ACTIVITY CLICK", "LECTURE MODE EN COURS >" + modeEnCours + "< resultOfComparison=" + modeliste);


                    //mysqlhlpr.ControleVersionBaseDeDonnees(context,dtsparam.getDatabase());

                    //Log.v("MAIN","FIN TRAITEMENT VERSIONDATABASE >"+nversion+"<");


                    dtsparam.close();


                    finish();

                    startActivity(getIntent());


                }
            });
        }


        LinearLayoutlisteproduits.addView(gabaritListeDet);



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

    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }
}
