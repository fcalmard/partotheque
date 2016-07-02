package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import acquisti.ouccelo.free.fr.acquisti.acquisti.ArticleDataSource;
import acquisti.ouccelo.free.fr.acquisti.acquisti.FamillesDataSource;

public class initbd extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_initbd2);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
finish();            }
        });
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    public void InitBaseDedonnees(View view)
    {
        ArticleDataSource artds = new ArticleDataSource(this);
        artds.open();
        artds.init();
        artds.close();
    }
}
