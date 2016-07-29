package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.content.ContentValues;
import android.content.Context;
import android.content.res.Resources;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import java.util.ArrayList;
import java.util.List;

public class FamillesDataSource {

	// Database fields
	private SQLiteDatabase database;
	private MySQLiteHelper dbHelper;
	private String[] allColumns = { MySQLiteHelper.COLUMN_ID,
			MySQLiteHelper.COLUMN_LIBELLE };
	private Context context;

	public FamillesDataSource(Context context) {
		dbHelper = new MySQLiteHelper(context);
		this.context=context;
	}

	public void open() throws SQLException {
		database = dbHelper.getWritableDatabase();
	}

	public void close() {
		dbHelper.close();
	}

	public Famille createFamille(String libelle) {
        Famille newFamille=null;

		ContentValues values = new ContentValues();
        values.put(MySQLiteHelper.COLUMN_LIBELLE, libelle);
        long insertId=0;

        Log.d("TEST","insertion FAMILLE 1 "+libelle);

		try{
           // database.beginTransaction();

            Log.d("TEST","insertion FAMILLE 2 "+libelle);

			insertId = database.insert(MySQLiteHelper.TABLE_FAMILLES, null,
					values);

            //database.endTransaction();

            Log.d("TEST","insertion FAMILLE 3 "+libelle+" ID="+insertId);

		}
		catch (Exception e){

			Log.d("TEST","insertion FAMILLE************** ERREUR= "+e.getMessage());

		}
        Log.d("TEST","insertion FAMILLE 4 "+libelle+" ID="+insertId);

        if (insertId!=0)
        {
            Cursor cursor = database.query(MySQLiteHelper.TABLE_FAMILLES,
                    allColumns, MySQLiteHelper.COLUMN_ID + " = " + insertId, null,
                    null, null, null);
            Log.d("TEST","insertion FAMILLE 5 "+libelle+" COUNT ="+cursor.getCount());
            if(cursor.getCount()>0)
            {
                cursor.moveToFirst();
                newFamille = cursorToFamille(cursor);

            }
            cursor.close();

        }
        Log.d("TEST","insertion FAMILLE 6 "+libelle);

        return newFamille;
	}
	
	public void updateFamille(Famille famille){
		ContentValues values = new ContentValues();

        values.put(MySQLiteHelper.COLUMN_LIBELLE, famille.getLibelle());

		database.update(MySQLiteHelper.TABLE_FAMILLES, values,
				MySQLiteHelper.COLUMN_ID + " = ? ",
				new String[] { String.valueOf(famille.getId()) });
	}

	public void deleteFamille(Famille famille) {
		long id = famille.getId();
		database.delete(MySQLiteHelper.TABLE_FAMILLES,
				MySQLiteHelper.COLUMN_ID + " = " + id, null);
	}

	public List<Famille> getAllFamilles(boolean spin) {
		List<Famille> familles = new ArrayList<>();

		if(spin)
		{
            //getres R.string.msgsaisiefam

           //String s= R.string.msgsaisiefam.getString();
			// Resources res = new Resources();
			String s="Famille";

s=			this.context.getResources().getString(R.string.msgsaisiefam);

//

           // String s=Resources.getSystem().getString(R.string.msgsaisiefam);
            Famille famille0 = new Famille(0,s);
			familles.add(famille0);
		}


		Cursor cursor = database.query(MySQLiteHelper.TABLE_FAMILLES,
				allColumns, null, null, null, null, null);

		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Famille famille = cursorToFamille(cursor);
			familles.add(famille);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return familles;
	}

	public List<Famille> getAllFamilles(String order) {

		List<Famille> familles = new ArrayList<Famille>();
//, null, null, null, null, null);
		Cursor cursor = database.query(MySQLiteHelper.TABLE_FAMILLES,
				allColumns,null,null,null,null,order);

		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Famille famille = cursorToFamille(cursor);
			familles.add(famille);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return familles;

	}

	private Famille cursorToFamille(Cursor cursor) {
		Famille famille = new Famille();
		famille.setId(cursor.getLong(0));
		famille.setLibelle(cursor.getString(1));
		return famille;
	}



}
