package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import java.util.ArrayList;
import java.util.List;

public class ParamDataSource {

	// Database fields
	private SQLiteDatabase database;
	private MySQLiteHelper dbHelper;

	public ParamDataSource(Context context) {
		dbHelper = new MySQLiteHelper(context);
	}

	public void open() throws SQLException {
		database = dbHelper.getWritableDatabase();
	}

    public SQLiteDatabase getDatabase()
    {
        return this.database;
    }

	public void close() {
		dbHelper.close();
        this.database=null;
	}

	public Param createParam(int versionbd,String modeencours,int modectrl) {
        Param newParam=null;

		ContentValues values = new ContentValues();

        //MySQLiteHelper.PARAM_MODEENCOURS_ACHAT
        //MySQLiteHelper.PARAM_MODEENCOURS_LISTE;

        values.put(MySQLiteHelper.PARAM_COLUMN_VBD, versionbd);


        values.put(MySQLiteHelper.PARAM_COLUMN_MODEENCOURS, modeencours);

		switch (versionbd)
		{
			case 2:

				break;

		}
        values.put(MySQLiteHelper.PARAM_COLUMN_MODECONTROLE, modectrl);

        long insertId=0;

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };


       /* Log.d("TEST","insertion PARAM 1 "+versionbd);
        Log.d("TEST","insertion PARAM 1 modeencours >"+modeencours+"<");
       *
       * */

		try{
			insertId = database.insert(MySQLiteHelper.TABLE_PARAM, null,values);
		}
		catch (Exception e){

			//Log.d("TEST","insertion PARAM************** ERREUR= "+e.getMessage());

		}
        //Log.d("NEWPARAM","insertion PARAM 4 "+versionbd+" ID="+insertId);

        if (insertId!=0)
        {
            Cursor cursor = database.query(MySQLiteHelper.TABLE_PARAM,
                    allColumns, MySQLiteHelper.COLUMN_ID + " = " + insertId, null,
                    null, null, null);
            //Log.d("*** NEWPARAM OK","PARAM COUNT ="+cursor.getCount());
            if(cursor.getCount()>0)
            {
                cursor.moveToFirst();
				newParam = cursorToParam(cursor);

            }
            cursor.close();

        }
        //Log.d("TEST","insertion PARAM 6 "+versionbd);

        return newParam;
	}
	
	public void updateParam(Param param){
		ContentValues values = new ContentValues();

        values.put(MySQLiteHelper.PARAM_COLUMN_VBD, param.getversionBd());

		values.put(MySQLiteHelper.PARAM_COLUMN_MODEENCOURS, param.getModeencours());

		values.put(MySQLiteHelper.PARAM_COLUMN_MODECONTROLE, param.getBmodectrl());

        /*Log.d("UPDATEPARAM"," >ID >"+param.getId()+"<<<<<<");
		Log.d("UPDATEPARAM"," VBD >>>>>>>"+param.getversionBd()+"<<<<<<");
		Log.d("UPDATEPARAM"," MODE >>>>>>>"+param.getModeencours()+"<<<<<<");
		Log.d("UPDATEPARAM"," MODECTRL >>>>>>>"+param.getBmodectrl()+"<<<<<<");*/

		database.update(MySQLiteHelper.TABLE_PARAM, values,
				MySQLiteHelper.COLUMN_ID + " = ? ",
				new String[] { String.valueOf(param.getId()) });
	}

	public void deleteParam(Param param) {
		long id = param.getId();
		database.delete(MySQLiteHelper.TABLE_PARAM,
				MySQLiteHelper.COLUMN_ID + " = " + id, null);
	}

	public List<Param> getAllParams(boolean spin) {
		List<Param> params = new ArrayList<>();

		if(spin)
		{
			Param param0 = new Param(0,0,"Saisissez un param");
			params.add(param0);
		}

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };

		//Log.v("PARAM DATA SOURCE, LISTE PARAMETRES ","134");

		Cursor cursor = database.query(MySQLiteHelper.TABLE_PARAM,
				allColumns, null, null, null, null, null);

		//Log.v("PARAM DATA SOURCE, LISTE PARAMETRES ","139");

		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Param param = cursorToParam(cursor);
			params.add(param);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return params;
	}

	public List<Param> getAllParams(String order) {

		List<Param> params = new ArrayList<Param>();

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };
		//Log.v("PARAM DATA SOURCE, LISTE PARAMETRES ","158");

		Cursor cursor = database.query(MySQLiteHelper.TABLE_PARAM,
				allColumns,null,null,null,null,order);
		//Log.v("PARAM DATA SOURCE, LISTE PARAMETRES ","162");

		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Param param = cursorToParam(cursor);
			params.add(param);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return params;

	}

	public Param cursorToParam(Cursor cursor) {
		Param param = new Param();
		Long id= cursor.getLong(0);
        param.setId(id);
        param.setversionBd(cursor.getInt(1));
        String s=cursor.getString(2);
        param.setModeencours(s);
		return param;
	}

    public String ParamChangeMode()
    {
        String snouveaumode=MySQLiteHelper.PARAM_MODEENCOURS_LISTE;
		//Log.v("PARAM DATA SOURCE, CHANGE MODE ","189");

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };

        Cursor cursor = database.query(MySQLiteHelper.TABLE_PARAM,
                allColumns,null,null,null,null,null);
		//Log.v("PARAM DATA SOURCE, CHANGE MODE ","196");

        //Log.d("PARAMCHANGEMODE"," GETCOUNT >"+cursor.getCount()+"<");

        int c=0;
        cursor.moveToFirst();
       // while (!cursor.isAfterLast()) {
        if (!cursor.isAfterLast()) {
            c++;
            Param param = cursorToParam(cursor);

            String smode=param.getModeencours();

            switch (smode) {
                case MySQLiteHelper.PARAM_MODEENCOURS_ACHAT:

                    snouveaumode = MySQLiteHelper.PARAM_MODEENCOURS_LISTE;


                    break;
                case MySQLiteHelper.PARAM_MODEENCOURS_LISTE:

                    snouveaumode = MySQLiteHelper.PARAM_MODEENCOURS_ACHAT;

                    break;
                default:
                    snouveaumode = MySQLiteHelper.PARAM_MODEENCOURS_LISTE;
                    break;

            }

            param.setModeencours(snouveaumode);

            updateParam(param);

        }
        // make sure to close the cursor
        cursor.close();

        return snouveaumode;

    }

}
