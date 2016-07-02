package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.app.ListActivity;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.Toast;

import java.util.Comparator;
import java.util.List;

public class Articles extends ListActivity implements AdapterView.OnItemSelectedListener, View.OnClickListener {

    EditText editText;
    Spinner spin;

    private ArticleDataSource datasource;


    // affichage
    private ImageButton imagebutton1;
    private ImageButton imagebutton2;
    private ImageButton imagebutton3;
    private ImageButton imagebutton4;

    Article articleSelected = null;

    private ArrayAdapter<Article> myAdapterArt;
    private ArrayAdapter<Famille> myAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.articles);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
       // setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
       // getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }
    @Override
    public void onStart()
    {
        super.onStart();

        datasource = new ArticleDataSource(this);
        datasource.open();

        // ouverture d'une connexion avec la bdd
        FamillesDataSource datasourcefam = new FamillesDataSource(this);
        datasourcefam.open();

        editText = (EditText) findViewById(R.id.editText1);
        spin = (Spinner) findViewById(R.id.spinner_famille);

        // on récupère les articles
        List<Article> listValuesArt = datasource.getAllArticles();

        editText = (EditText) findViewById(R.id.editText1);
        spin = (Spinner) findViewById(R.id.spinner_famille);


        // on créé un adapter pour les familles

        myAdapterArt = new ArrayAdapter<Article>(this, R.layout.row_layout_article, R.id.listTextArt, listValuesArt);

        // assign the list adapter
        setListAdapter(myAdapterArt);

        // on récupère les familles
        List<Famille> listValues = datasourcefam.getAllFamilles(true);

        myAdapter = new ArrayAdapter<Famille>(this, R.layout.row_layout_fam,
                R.id.listText, listValues);

        spin.setOnItemSelectedListener(this);

        spin.setAdapter(myAdapter);

        spin.setPrompt("Selectionnez une famille");

        /*
        boutons
         */
        imagebutton1 = (ImageButton) findViewById(R.id.imageButton1);//MAJ
        imagebutton1.setOnClickListener(this);
        imagebutton1.setImageResource(android.R.drawable.ic_input_add);

        imagebutton2 = (ImageButton) findViewById(R.id.imagebutton2);//RESET
        imagebutton2.setOnClickListener(this);
        imagebutton2.setEnabled(false);

        imagebutton3 = (ImageButton) findViewById(R.id.imageButton3);
        imagebutton3.setOnClickListener(this);
        imagebutton3.setEnabled(false);

        imagebutton4 = (ImageButton) findViewById(R.id.imageButton4);
        imagebutton4.setOnClickListener(this);
        imagebutton4.setEnabled(true);


    }
    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {

    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {

    }


    public void onClick(View v) {

        /*
        AJOUT MODIFICATION
         */
        if (v.getId() == R.id.imageButton1) {
            if (editText.getText().length() > 0) {
                long ifam = spin.getSelectedItemId();
                if (ifam > 0) {
                    if (articleSelected != null) {
                        // UPDATE
                        articleSelected.setLibelle(editText.getText().toString());

                        articleSelected.setFamilleId(ifam);

                        datasource.updateArticle(articleSelected);
                    } else {
                        // CREATE
                        myAdapterArt.add(datasource.createArticle(editText.getText().toString(), spin.getSelectedItemId()));
                        editText.setText("");
                    }
                    myAdapter.notifyDataSetChanged();
                } else {
                    Toast toast = Toast.makeText(this, "Famille invalide !",
                            Toast.LENGTH_SHORT);
                    toast.show();
                }

            } else {
                Toast toast = Toast.makeText(this, "Pas de nom!",
                        Toast.LENGTH_SHORT);
                toast.show();
            }

        }

        /*
        REINIT SAISIE
         */
        if (v.getId() == R.id.imagebutton2) {
            articleSelected = null;
            editText.setText("");
            spin.setSelection(0);

            imagebutton1.setImageResource(android.R.drawable.ic_input_add);
        }

        /*
        DELETE
         */
        if (v.getId() == R.id.imageButton3) {
            if (articleSelected != null) {
                editText.setText("");

                spin.setSelection(0);

                imagebutton1.setImageResource(android.R.drawable.ic_input_add);

                datasource.deleteArticle(articleSelected);
                myAdapterArt.remove(articleSelected);
                myAdapterArt.notifyDataSetChanged();
                articleSelected = null;
            }

        }

        //TRI
        if (v.getId() == R.id.imageButton4) {


            Drawable drawable = imagebutton4.getDrawable();

            if (drawable.getConstantState().equals(getResources().getDrawable(android.R.drawable.arrow_up_float).getConstantState())) {
                //Do your work here StringDescComparator StringAscComparator
                imagebutton4.setImageResource(android.R.drawable.arrow_down_float);

                myAdapterArt.sort(StringAscComparator);

            } else {
                imagebutton4.setImageResource(android.R.drawable.arrow_up_float);

                myAdapterArt.sort(StringDescComparator);

            }
            articleSelected = null;

            editText.setText("");

            myAdapter.notifyDataSetChanged();

            imagebutton1.setImageResource(android.R.drawable.ic_input_add);


        }


    }

    @Override
    protected void onListItemClick(ListView list, View view, int position,
                                   long id) {
        super.onListItemClick(list, view, position, id);

        articleSelected = (Article) getListView().getItemAtPosition(position);

        editText.setText(articleSelected.getLibelle());

        spin.setSelection((int) articleSelected.getFamilleId());

        imagebutton1.setImageResource(android.R.drawable.ic_menu_edit);

        imagebutton2.setEnabled(true);
        imagebutton3.setEnabled(true);


    }


    public static Comparator<Article> StringDescComparator = new Comparator<Article>() {

        public int compare(Article app1, Article app2) {

            String stringName1 = app2.getLibelle();
            String stringName2 = app1.getLibelle();

            return stringName2.compareToIgnoreCase(stringName1);
        }
    };
    public static Comparator<Article> StringAscComparator = new Comparator<Article>() {

        public int compare(Article app1, Article app2) {

            String stringName1 = app1.getLibelle();
            String stringName2 = app2.getLibelle();

            return stringName2.compareToIgnoreCase(stringName1);
        }
    };

}
