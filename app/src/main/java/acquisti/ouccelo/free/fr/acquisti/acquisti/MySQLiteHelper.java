package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class MySQLiteHelper extends SQLiteOpenHelper {

    private static final int DATABASE_VERSION = 1;

    public static final String TABLE_PARAM = "parametres";
    public static final String PARAM_MODEENCOURS_LISTE = "L";
    public static final String PARAM_MODEENCOURS_ACHAT = "A";


    public static final String PARAM_COLUMN_VBD = "version_bd";
    public static final String PARAM_COLUMN_MODEENCOURS = "modeencours";

    public static final String RECH_TABLE_PARAM = "select "+PARAM_COLUMN_VBD+" from "+TABLE_PARAM;


    public static final String TABLE_ARTICLES = "articles";
	public static final String COLUMN_ID = "_id";
	public static final String COLUMN_LIBELLE = "libelle ";
    public static final String COLUMN_ID_FAMILLE = "FamilleId";
    public static final String COLUMN_IMG = "img";


    public static final String TABLE_FAMILLES = "familles";

    public static final String RECH_TABLE_PARAM_ALL = "select "+COLUMN_ID+","+PARAM_COLUMN_VBD+","+PARAM_COLUMN_MODEENCOURS+" from "+TABLE_PARAM;

    private static final String DATABASE_NAME = "articles.db";

	// Database creation sql statement
    private static final String TABLE_CREATE_PARAM = "create table "
            + TABLE_PARAM + "(" + COLUMN_ID
            + " integer primary key autoincrement, "
            + PARAM_COLUMN_VBD + " integer not null,"
            + PARAM_COLUMN_MODEENCOURS + " text not null"
            +");";
	private static final String TABLE_CREATE_ARTICLE = "create table "
			+ TABLE_ARTICLES + "(" + COLUMN_ID
			+ " integer primary key autoincrement, "
			+ COLUMN_LIBELLE + " text not null unique,"
	        + COLUMN_ID_FAMILLE + " integer not null"
			+");";

	private static final String TABLE_CREATE_FAMILLE = "create table "
			+ TABLE_FAMILLES + "(" + COLUMN_ID
			+ " integer primary key autoincrement, "
			+ COLUMN_LIBELLE + " text not null unique"
			+");";


	public MySQLiteHelper(Context context) {
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}

    public String ModeEnCours(Context context,SQLiteDatabase db,boolean bMaj)
    {
        int vbd=0;
        String modeencours="";
        Long idparam= Long.valueOf(0);

        Param newParam = new Param();

        //lire depuis bd

        try {

            // Log.d("RECH_TABLE_PARAM0",RECH_TABLE_PARAM);

            String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                    MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };

            Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                    allColumns, null, null,
                    null, null, null);

            //Log.d("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());
            int nbc=cursor.getCount();

            if(nbc>0)
            {
                cursor.moveToFirst();

                vbd=cursor.getInt(1);

                modeencours=cursor.getString(2);

                if(bMaj)
                {


                    ParamDataSource pds = new ParamDataSource(context);
                    pds.open();

                    newParam = pds.cursorToParam(cursor);

                    boolean modeliste=modeencours.equals(PARAM_MODEENCOURS_LISTE);

                    Log.d("MODE EN COURS ", "LECTURE MODE EN COURS >" + modeencours + "< resultOfComparison=" + modeliste);

                    if (modeliste)
                    {
                        modeencours=MySQLiteHelper.PARAM_MODEENCOURS_ACHAT;
                        Log.d("MODE EN COURS ","PASSAGE EN MODE ACHAT");
                    }else
                    {
                        modeencours=MySQLiteHelper.PARAM_MODEENCOURS_LISTE;
                        Log.d("MODE EN COURS ","PASSAGE EN MODE LISTE");

                    }

                    Log.d("MODE EN COURS ","maj MODE EN COURS >"+modeencours+"< mode LISTE >"+MySQLiteHelper.PARAM_MODEENCOURS_LISTE+"<");

                    newParam.setModeencours(modeencours);

                    pds.updateParam(newParam);

                    pds.close();
                }



            }else{

                //Log.d("NOMBREZERO"," LECTURE NBC=0");

                vbd=1;

                //newParam.setversionBd(vbd);

                //Log.d("NOMBREZERO"," VERSION BASE DE DONNEES ");

                //newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                //Log.d("NOMBREZERO"," MODE EN COURS ");

                ParamDataSource pds = new ParamDataSource(context);
                pds.open();

                newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                idparam=newParam.getId();

                //Log.d("NOMBREZERO"," ID NOUVEAU PARAM = "+idparam);

                pds.close();

            }

            cursor.close();

            //Log.d("RECH_TABLE_PARAM1"," RECHERCHE  1 ID PARAM = "+idparam.toString());

        }catch (SQLiteException e)//Exception
        {


            //String smode=PARAM_MODEENCOURS_LISTE;

            //Param nparam = new Param(0,versionBd,smode);

            //Log.d("ERREURCONTROLEVERSIONBD"," ERREURSTRING  "+e.toString()+" CAUSE "+e.getCause());
            //Log.d("ERREURCONTROLEVERSIONBD"," RECHERCHE  "+e.getMessage());
/**/
            db.execSQL("DROP TABLE IF EXISTS " + TABLE_PARAM);

            db.execSQL(TABLE_CREATE_PARAM);

            // newParam.setversionBd(1);
            vbd=1;
            // newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

            ParamDataSource pds = new ParamDataSource(context);
            pds.open();
            newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

            /* idparam=newParam.getId(); */

            Log.d("ERREURCONTROLEVERSIONBD",TABLE_CREATE_PARAM+" IDPARAM="+idparam);

            pds.close();

        }



        switch (modeencours)
        {
            case PARAM_MODEENCOURS_ACHAT:
                break;
            case PARAM_MODEENCOURS_LISTE:
                break;
        default:
            modeencours=PARAM_MODEENCOURS_LISTE;
        }

        // maj bd

        return modeencours;

    }
    public int ControleVersionBaseDeDonnees(Context context,SQLiteDatabase db)
    {
        int vbd=0;
        Long idparam= Long.valueOf(0);

        Param newParam = new Param();

        try {

           // Log.d("RECH_TABLE_PARAM0",RECH_TABLE_PARAM);

            String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                    MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };


            Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                    allColumns, null, null,
                    null, null, null);

            //Log.d("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());
            int nbc=cursor.getCount();

            if(nbc>0)
            {
                cursor.moveToFirst();

                vbd=cursor.getInt(1);

            }else{

                //Log.d("NOMBREZERO"," LECTURE NBC=0");


                vbd=1;

                //newParam.setversionBd(vbd);

                //Log.d("NOMBREZERO"," VERSION BASE DE DONNEES ");

                //newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                //Log.d("NOMBREZERO"," MODE EN COURS ");

                ParamDataSource pds = new ParamDataSource(context);
                pds.open();

                newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                idparam=newParam.getId();

                //Log.d("NOMBREZERO"," ID NOUVEAU PARAM = "+idparam);

                pds.close();

            }

            cursor.close();

            //Log.d("RECH_TABLE_PARAM1"," RECHERCHE  1 ID PARAM = "+idparam.toString());

        }catch (SQLiteException e)//Exception
        {


            //String smode=PARAM_MODEENCOURS_LISTE;

            //Param nparam = new Param(0,versionBd,smode);

            //Log.d("ERREURCONTROLEVERSIONBD"," ERREURSTRING  "+e.toString()+" CAUSE "+e.getCause());
            //Log.d("ERREURCONTROLEVERSIONBD"," RECHERCHE  "+e.getMessage());
/**/
            db.execSQL("DROP TABLE IF EXISTS " + TABLE_PARAM);

            db.execSQL(TABLE_CREATE_PARAM);

           // newParam.setversionBd(1);
            vbd=1;
           // newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

            ParamDataSource pds = new ParamDataSource(context);
            pds.open();
            newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

            /* idparam=newParam.getId(); */

            Log.d("ERREURCONTROLEVERSIONBD",TABLE_CREATE_PARAM+" IDPARAM="+idparam);

            pds.close();

        }


        //Log.d("RECH_TABLE_PARAM2"," RECHERCHE  2 VERSION BASE DE DONNEES "+vbd);

        return vbd;
    }

    public void majBaseDeDonnees(Context context,SQLiteDatabase db,int version)
    {
        Param param = new Param();

        Log.d("majBaseDeDonnees", "version "+ version);

        switch (version)
        {
            case 1://
                break;
            case 2:/* ajout champ COLUMN_IMG à la TABLE_ARTICLES*/

                String sql = "ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_IMG+" BLOB DEFAULT NULL";

                try {
                    db.execSQL(sql);
                    sql = "ALTER TABLE "+TABLE_ARTICLES+" DROP COLUMN "+COLUMN_IMG;
                    db.execSQL(sql);

                }catch (SQLiteException e)
                {
                   Log.d("ERREUR MAJVBD",e.getMessage().toString());

                }


                ParamDataSource pds = new ParamDataSource(context);
                pds.open();

                String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                        MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };



                //db.query(TABLE_ARTICLES,allColumns,"",allColumns,"","","");

                Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                        allColumns, null, null,
                        null, null, null);

                int nbc=cursor.getCount();

                if(nbc>0)
                {
                    cursor.moveToFirst();

                    param = pds.cursorToParam(cursor);

                    String msg="VBD "+param.getversionBd();

                    //Log.v("**********VBD=",msg);

                    param.setversionBd(version);

                    pds.updateParam(param);

                    //Log.v("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());


                }else{

                }

                pds.close();

                cursor.close();

                break;
            default:
                break;
        }
    }

	@Override
	public void onCreate(SQLiteDatabase db) {
        db.execSQL(TABLE_CREATE_PARAM);
        db.execSQL(TABLE_CREATE_ARTICLE);
		db.execSQL(TABLE_CREATE_FAMILLE);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_PARAM);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_ARTICLES);
		db.execSQL("DROP TABLE IF EXISTS " + TABLE_FAMILLES);
		onCreate(db);
	}

}
