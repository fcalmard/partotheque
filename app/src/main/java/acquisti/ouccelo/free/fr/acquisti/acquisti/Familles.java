package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.app.ListActivity;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;

import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Toast;

import java.util.Comparator;
import java.util.List;


public class Familles extends ListActivity implements View.OnClickListener{

        /*
    bdd FAMILLES
     */

    private FamillesDataSource datasource;

    // affichage
    private ImageButton imagebutton1;
    private ImageButton imagebutton2;
    private ImageButton imagebutton3;
    private ImageButton imagebutton4;
    EditText editText;

    Famille familleSelected = null;

    // adapter
    private ArrayAdapter<Famille> myAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_familles);
        //Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        //setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
        //getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }


    @Override
    public void onStart() {
        super.onStart();

        familleSelected=null;


        // ouverture d'une connexion avec la bdd
        datasource = new FamillesDataSource(this);
        datasource.open();

        // nos boutons

        imagebutton1 = (ImageButton) findViewById(R.id.imageButton1);
        imagebutton1.setOnClickListener((View.OnClickListener) this);
        imagebutton1.setImageResource(android.R.drawable.ic_input_add);

        imagebutton2 = (ImageButton) findViewById(R.id.imagebutton2);
        imagebutton2.setOnClickListener(this);
        imagebutton2.setEnabled(false);

        imagebutton3 = (ImageButton) findViewById(R.id.imageButton3);
        imagebutton3.setOnClickListener(this);
        imagebutton3.setEnabled(false);

        imagebutton4 = (ImageButton) findViewById(R.id.imageButton4);
        imagebutton4.setOnClickListener(this);
        imagebutton4.setEnabled(true);


        // notre champ de saisie

        editText = (EditText) findViewById(R.id.editText1);


        // on récupère les familles
        List<Famille> listValues = datasource.getAllFamilles(false);

        // on créé un adapter
        myAdapter = new ArrayAdapter<Famille>(this, R.layout.row_layout_fam,
                R.id.listText, listValues);

        // assign the list adapter

        setListAdapter(myAdapter);


    }


    @Override
    public void onClick(View v) {

        if (v.getId() == R.id.imageButton1) {
            if (editText.getText().length() > 0) {
                if (familleSelected != null) {
                    // UPDATE
                    familleSelected.setLibelle(editText.getText().toString());
                    datasource.updateFamille(familleSelected);
                } else {
                    // CREATE
                    myAdapter.add(datasource.createFamille(editText.getText()
                            .toString()));
                    editText.setText("");
                }
                myAdapter.notifyDataSetChanged();
            } else {
                Toast toast = Toast.makeText(this, "Pas de nom!",
                        Toast.LENGTH_SHORT);
                toast.show();
            }

        }

        if (v.getId() == R.id.imagebutton2) {
            familleSelected = null;
            editText.setText("");
            imagebutton1.setImageResource(android.R.drawable.ic_input_add);
        }

        if (v.getId() == R.id.imageButton3) {
            if (familleSelected != null) {
                editText.setText("");
                imagebutton1.setImageResource(android.R.drawable.ic_input_add);

                datasource.deleteFamille(familleSelected);
                myAdapter.remove(familleSelected);
                myAdapter.notifyDataSetChanged();
                familleSelected = null;
            }

        }

        //TRI
        if (v.getId() == R.id.imageButton4) {


            Drawable drawable = imagebutton4.getDrawable();

            if (drawable.getConstantState().equals(getResources().getDrawable(android.R.drawable.arrow_up_float).getConstantState())){
                //Do your work here StringDescComparator StringAscComparator
                imagebutton4.setImageResource(android.R.drawable.arrow_down_float);


                myAdapter.sort(StringDescComparator);
            }else {
                imagebutton4.setImageResource(android.R.drawable.arrow_up_float);

                myAdapter.sort(StringAscComparator);

            }
            familleSelected = null;

            editText.setText("");

            myAdapter.notifyDataSetChanged();

            imagebutton1.setImageResource(android.R.drawable.ic_input_add);


        }


    }

    @Override
    protected void onListItemClick(ListView list, View view, int position,
                                   long id) {
        super.onListItemClick(list, view, position, id);

        familleSelected = (Famille) getListView().getItemAtPosition(position);

        editText.setText(familleSelected.getLibelle());

        imagebutton1.setImageResource(android.R.drawable.ic_menu_edit);

        imagebutton2.setEnabled(true);
        imagebutton3.setEnabled(true);


    }

    public static Comparator<Famille> StringDescComparator = new Comparator<Famille>() {

        public int compare(Famille app1, Famille app2) {

            String stringName1 = app2.getLibelle();
            String stringName2 = app1.getLibelle();

            return stringName2.compareToIgnoreCase(stringName1);
        }
    };

    public static Comparator<Famille> StringAscComparator = new Comparator<Famille>() {

        public int compare(Famille app1, Famille app2) {

            String stringName1 = app1.getLibelle();
            String stringName2 = app2.getLibelle();

            return stringName2.compareToIgnoreCase(stringName1);
        }
    };

}
