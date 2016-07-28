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

    public static final int PARAM_MAJ_MODEENCOURS = 1;
    public static final int PARAM_MAJ_CTRLMODE = 2;

    public static final String PARAM_COLUMN_MODECONTROLE = "modecontrole";
    public static final String PARAM_COLUMN_LISTEENCOURS = "idlisteencours";

    public static final String RECH_TABLE_PARAM = "select "+PARAM_COLUMN_VBD+" from "+TABLE_PARAM;


    public static final String TABLE_ARTICLES = "articles";
	public static final String COLUMN_ID = "_id";
	public static final String COLUMN_LIBELLE = "libelle ";
    public static final String COLUMN_ID_FAMILLE = "FamilleId";
    public static final String COLUMN_IMG = "img";

    public static final String COLUMN_DSLISTE = "idliste";// SI MODE LISTE INTEGER OU IDENTIFIANT LISTE SELECTIONEE OUI 1 0
    public static final String COLUMN_DSACHATS = "estachete";// SI MODE ACHAT INTEGER OUI O 10

    public static final String COLUMN_PUHT = "puht";
    public static final String COLUMN_TXTVA = "txtva";
    public static final String COLUMN_PUTTC = "puttc";
    public static final String COLUMN_QTE = "qte";

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

    public Param MiseAJourParam(Context context,SQLiteDatabase db,boolean bMaj,int iTypeMaj,Param oParam)
    {
        int vbd=0;
        String modeencours="";
        int ctrlactive=0;

        Long idparam= Long.valueOf(0);

        Param newParam = new Param();
        //Log.v("MYSQL HELPER MAJ PARAM","85");
        //lire depuis bd

        try {

            // Log.d("RECH_TABLE_PARAM0",RECH_TABLE_PARAM);

            String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                    MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS,MySQLiteHelper.PARAM_COLUMN_MODECONTROLE };

            Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                    allColumns, null, null,
                    null, null, null);

            //Log.d("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());
            int nbc=cursor.getCount();
            //Log.v("MYSQL HELPER MAJ PARAM","101 NBC="+nbc);

            if(nbc>0)
            {
                cursor.moveToFirst();

                vbd=cursor.getInt(1);

                modeencours=cursor.getString(2);

                ctrlactive=cursor.getInt(3);
                //Log.v("MYSQL HELPER MAJ PARAM","112");

                if(bMaj)
                {
                    final ParamDataSource pds = new ParamDataSource(context);
                    pds.open();

                    newParam = pds.cursorToParam(cursor);

                    boolean modeliste=modeencours.equals(PARAM_MODEENCOURS_LISTE);
                    //Log.v("MYSQL HELPER MAJ PARAM","122");

                    switch (iTypeMaj)
                    {
                        case PARAM_MAJ_MODEENCOURS:

                            //Log.d("MODE EN COURS ", "LECTURE MODE EN COURS >" + modeencours + "< resultOfComparison=" + modeliste);

                            if (modeliste)
                            {
                                modeencours=MySQLiteHelper.PARAM_MODEENCOURS_ACHAT;
                                //Log.d("MODE EN COURS ","PASSAGE EN MODE ACHAT");
                            }else
                            {
                                modeencours=MySQLiteHelper.PARAM_MODEENCOURS_LISTE;
                                // Log.d("MODE EN COURS ","PASSAGE EN MODE LISTE");

                            }

                            //Log.d("MODE EN COURS ","maj MODE EN COURS >"+modeencours+"< mode LISTE >"+MySQLiteHelper.PARAM_MODEENCOURS_LISTE+"<");

                            newParam.setModeencours(modeencours);

                            //newParam.setBmodectrl(ctrlactive==1);
                            //Log.v("MYSQL HELPER MAJ PARAM","146");

                            pds.updateParam(newParam);
                            //Log.v("MYSQL HELPER MAJ PARAM","149");

                            pds.close();

                            break;


                        case PARAM_MAJ_CTRLMODE:

                            //Log.d("MODE EN COURS ", "LECTURE MODE EN COURS >" + modeencours + "< resultOfComparison=" + modeliste);



                            //Log.d("MODE EN COURS ","maj MODE EN COURS >"+modeencours+"< mode LISTE >"+MySQLiteHelper.PARAM_MODEENCOURS_LISTE+"<");
                            newParam.setversionBd(vbd);

                            if(ctrlactive==1)
                            {
                                ctrlactive=0;
                            }else{
                                ctrlactive=1;
                            }

                            newParam.setBmodectrl(ctrlactive==1);

                            pds.updateParam(newParam);

                            pds.close();
                            break;
                    }
                }
                //Log.v("MYSQL HELPER MAJ PARAM","180");

                if(iTypeMaj==PARAM_MAJ_MODEENCOURS)
                {


                }



            }else{

                //Log.d("NOMBREZERO"," LECTURE NBC=0");
                //Log.v("MYSQL HELPER MAJ PARAM","193");

                vbd=1;

                ctrlactive=0;

                //newParam.setversionBd(vbd);

                //Log.d("NOMBREZERO"," VERSION BASE DE DONNEES ");

                //newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                //Log.d("NOMBREZERO"," MODE EN COURS ");

                ParamDataSource pds = new ParamDataSource(context);
                pds.open();
                //Log.v("MYSQL HELPER MAJ PARAM","209");

                newParam=pds.createParam(3,MySQLiteHelper.PARAM_MODEENCOURS_LISTE,0);

                //Log.v("MYSQL HELPER MAJ PARAM","213");

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
            newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE,0);

            /* idparam=newParam.getId(); */

            //Log.d("ERREURCONTROLEVERSIONBD",TABLE_CREATE_PARAM+" IDPARAM="+idparam);

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

        //return modeencours;

        newParam.setBmodectrl(ctrlactive==1);

        newParam.setModeencours(modeencours);

        return newParam;

    }


    public int ControleVersionBaseDeDonnees(Context context,SQLiteDatabase db)
    {
        //Log.d("CtrlVBD",RECH_TABLE_PARAM);

        int vbd=0;
        Long idparam= Long.valueOf(0);

        Param newParam = new Param();

        try {

//MySQLiteHelper.PARAM_COLUMN_MODEENCOURS,MySQLiteHelper.PARAM_COLUMN_MODECONTROLE

            String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                    MySQLiteHelper.PARAM_COLUMN_VBD };


            Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                    allColumns, null, null,
                    null, null, null);

            //Log.d("RECH_TABLE_PARAM1","290 LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());

            int nbc=cursor.getCount();

            if(nbc>0)
            {
                cursor.moveToFirst();

                vbd=cursor.getInt(1);

            }else{

                //Log.d("RECH_TABLE_PARAM1"," 302 LECTURE NBC=0");

                vbd=1;

                this.majBaseDeDonnees(context,db,vbd);

                vbd=2;
                this.majBaseDeDonnees(context,db,vbd);

                vbd=3;
                this.majBaseDeDonnees(context,db,vbd);


                //newParam.setversionBd(vbd);

                //Log.d("NOMBREZERO"," VERSION BASE DE DONNEES ");

                //newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

                //Log.d("NOMBREZERO"," MODE EN COURS ");
/*
                ParamDataSource pds = new ParamDataSource(context);
                pds.open();

                newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE,0);

                idparam=newParam.getId();

                //Log.d("NOMBREZERO"," ID NOUVEAU PARAM = "+idparam);

                pds.close();

*/
                //Log.d("RECH_TABLE_PARAM1"," 314 MISE A JOURS EFFECTUEE");


            }

            cursor.close();

            //Log.d("RECH_TABLE_PARAM1"," RECHERCHE  1 ID PARAM = "+idparam.toString());

        }catch (SQLiteException e)//Exception
        {


            this.majBaseDeDonnees(context,db,1);
            this.majBaseDeDonnees(context,db,2);
            this.majBaseDeDonnees(context,db,3);

            //Log.d("CtrlVBD","333");


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
            newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE,0);

            /* idparam=newParam.getId(); */

            //Log.d("ERREURCONTROLEVERSIONBD",TABLE_CREATE_PARAM+" IDPARAM="+idparam);

            pds.close();

        }


        //Log.d("RECH_TABLE_PARAM2"," RECHERCHE  2 VERSION BASE DE DONNEES "+vbd);

        return vbd;
    }

    public void majBaseDeDonnees(Context context,SQLiteDatabase db,int version)
    {
        Param param = new Param();

        //Log.d("majBaseDeDonnees", "378 version "+ version);

        switch (version)
        {
            case 1://
                this.MiseAJourParamVersionBase(context,db,1);
                break;
            case 2:/* ajout champ COLUMN_IMG à la TABLE_ARTICLES*/

                String sql = "ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_IMG+" BLOB DEFAULT NULL";

                try {
                    db.execSQL(sql);
                    sql = "ALTER TABLE "+TABLE_ARTICLES+" DROP COLUMN "+COLUMN_IMG;
                    db.execSQL(sql);

                }catch (SQLiteException e)
                {
                   //Log.d("ERREUR MAJVBD",e.getMessage().toString());

                }

                this.MiseAJourParamVersionBase(context,db,2);

                /*
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
                */


                break;
            case 3:
                /*
                table ARTICLES LISTE ACHATS

                ajout COLUMN_PUHT COLUMN_TXTVA COLUMN_PUTTC COLUMN_QTE

                COLUMN_DSLISTE PREND 1 SI ARTICLE SELECTIONNE OU IDENTIFIANT DE LA LISTE

                COLUMN_DSACHATS PREND 1 SI ARTICLE SELECTIONNE

                TABLE TABLE_PARAM

                    SI PARAM_COLUMN_MODEENCOURS = EN MODE LISTE
                    CACHER  BTN PASSAGE EN MODE CONTROLE imageBtnActiverModeCtrl
                    SI PARAM_COLUMN_MODEENCOURS = EN MODE ACHAT

                        PARAM_COLUMN_MODECONTROLE

                            SI ARTICLE ACHETE
                                SI PARAM_COLUMN_MODECONTROLE= 0 SORT DE LA LISTE
                                SI PARAM_COLUMN_MODECONTROLE = 1 ON AFFICHE TOUTE LA LISTE


                 */
                String sqlart = "ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_PUHT+" REAL DEFAULT 0;";
                sqlart = sqlart  +"ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_TXTVA+" REAL DEFAULT 20.00;";
                sqlart = sqlart +"ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_PUTTC+" REAL DEFAULT 0;";
                sqlart = sqlart +"ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_QTE+" REAL DEFAULT 1;";

                sqlart = sqlart +"ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_DSLISTE+" INTEGER DEFAULT 0;";
                sqlart = sqlart +"ALTER TABLE "+TABLE_ARTICLES+" ADD COLUMN "+COLUMN_DSACHATS+" INTEGER DEFAULT 0;";

                String sqlparam= "ALTER TABLE "+TABLE_PARAM+" ADD COLUMN "+PARAM_COLUMN_MODECONTROLE+" INTEGER DEFAULT 0;";
                sqlparam = sqlparam +"ALTER TABLE "+TABLE_PARAM+" ADD COLUMN "+PARAM_COLUMN_LISTEENCOURS+" STRING DEFAULT '';";

                String sqlalterart = "ALTER TABLE "+TABLE_ARTICLES+" DROP COLUMN "+COLUMN_PUHT;

                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_TXTVA;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_PUTTC;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_QTE;

                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_DSLISTE;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_DSACHATS;

                String sqlalterparam = "ALTER TABLE "+TABLE_PARAM+" DROP COLUMN "+PARAM_COLUMN_MODECONTROLE;
                sqlalterparam=sqlalterparam+ "ALTER TABLE "+TABLE_PARAM+" DROP COLUMN "+PARAM_COLUMN_LISTEENCOURS;

                try {
                    db.execSQL(sqlart);
                    db.execSQL(sqlparam);


                    //db.execSQL(sqlalterart);
                    //db.execSQL(sqlalterparam);

                    this.MiseAJourParamVersionBase(context,db,2);


                }catch (SQLiteException e)
                {
                    //Log.d("ERREUR MAJVBD",e.getMessage().toString());

                }

                break;
            default:
                break;
        }
    }

    public void MiseAJourParamVersionBase(Context context,SQLiteDatabase db,int version)
    {
        Param param = new Param();

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

            //Log.v("MYSQLHELPER","559"+msg);

            param.setversionBd(version);
            //Log.v("MYSQLHELPER","562");

            pds.updateParam(param);

            //Log.v("MYSQLHELPER","566");

            //Log.v("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());


        }else{

        }

        pds.close();

        cursor.close();

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
