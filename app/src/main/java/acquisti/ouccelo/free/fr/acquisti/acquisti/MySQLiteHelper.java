package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;
import android.widget.Toast;

public class MySQLiteHelper extends SQLiteOpenHelper {

    private static final int DATABASE_VERSION = 1;

    public static final String TABLE_PARAM = "parametres";
    public static final String PARAM_MODEENCOURS_LISTE = "L";
    public static final String PARAM_MODEENCOURS_ACHAT = "A";


    public static final String PARAM_COLUMN_VBD = "version_bd";
    public static final String PARAM_COLUMN_MODEENCOURS = "modeencours";

    public static final int PARAM_MAJ_MODEENCOURS = 1;
    public static final int PARAM_MAJ_CTRLMODE = 2;
    public static final int PARAM_MAJ_FAMENCOURS = 3;

    public static final String PARAM_COLUMN_MODECONTROLE = "modecontrole";


    public static final String PARAM_COLUMN_LISTEENCOURS = "idlisteencours";
    public static final String PARAM_COLUMN_FAMENCOURS = "idfamencours";

    public static final String RECH_TABLE_PARAM_VBD = "select "+PARAM_COLUMN_VBD+" from "+TABLE_PARAM;


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
            + PARAM_COLUMN_MODEENCOURS + " text not null,"
            + PARAM_COLUMN_MODECONTROLE + " LONG DEFAULT 0,"
            + PARAM_COLUMN_LISTEENCOURS + " LONG DEFAULT 0,"
            + PARAM_COLUMN_FAMENCOURS + " LONG DEFAULT 0"
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

    public boolean MiseAJourParam2(Context context,SQLiteDatabase db,boolean bMaj,int iTypeMaj,Param oParam)
    {
        boolean bres;

        //Param newParam = new Param(1,4,PARAM_MODEENCOURS_LISTE,0,0,oParam.getFamilleEnCours());

        final ParamDataSource pds = new ParamDataSource(context);

        pds.open();

        bres=false;
        if(bMaj)
            switch (iTypeMaj) {
                case PARAM_MAJ_MODEENCOURS:

                   // String modeec = oParam.getModeencours();
                    pds.updateParam(oParam);
                   //Log.v("MYSQLHELPER", "PARAM_MAJ_MODEENCOURS,MiseAJourParam2 modeec=" + modeec);
                    bres = true;

                    break;
                case PARAM_MAJ_FAMENCOURS:

                    long famid = oParam.getFamilleEnCours();
                    //oParam.setFamilleEnCours();
                    //newParam.setFamilleEnCours(famid);

                    //pds.updateParam(newParam);
                    pds.updateParam(oParam);

                    //Log.v("MYSQL HELPER MAJ PARAM ", "PARAM_MAJ_FAMENCOURS 107 famid=" + famid);

                   //Toast.makeText(context, " 116 PARAM_MAJ_FAMENCOURS FAMILLEID="+famid, Toast.LENGTH_LONG).show();

                    bres = true;

                    break;
            }

        pds.close();

        return bres;

    }

    public Param LectureParam(Context context,SQLiteDatabase db)
    {
        Param newParam = new Param();

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD
                ,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS
                ,MySQLiteHelper.PARAM_COLUMN_MODECONTROLE
                ,MySQLiteHelper.PARAM_COLUMN_LISTEENCOURS
                ,MySQLiteHelper.PARAM_COLUMN_FAMENCOURS};

        Cursor cursor = db.query(MySQLiteHelper.TABLE_PARAM,
                allColumns, null, null,
                null, null, null);

        //Log.d("RECH_TABLE_PARAM1"," LECTURE "+TABLE_PARAM+" COUNT ="+cursor.getCount());
        int nbc=cursor.getCount();

        //Log.v("MYSQL, LECTURE PARAM","141 NBC="+nbc);

        if(nbc>0) {
            cursor.moveToFirst();

            final ParamDataSource pds = new ParamDataSource(context);

            //cursorToParam

            pds.open();

            //long ifam=cursor.getLong(5);

            //newParam.setFamilleEnCours(ifam);

            newParam = pds.cursorToParam(cursor);

            //Log.v("MYSQL, LECTURE PARAM","158 IFAM=getColumnCount="+cursor.getColumnCount()+" ID="+cursor.getLong(0));

            pds.close();

        }
        cursor.close();
        return newParam;

    }

    public int ControleVersionBaseDeDonnees(Context context,SQLiteDatabase db)
    {
        //Log.d("ControleVersionBaseDeDonnees"," RECHERCHE "+TABLE_PARAM);
       // db.execSQL("DROP TABLE IF EXISTS " + TABLE_PARAM);
        //Log.d("ControleVersionBaseDeDonnees"," APRES DROP "+TABLE_PARAM);

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

                //Log.d("RECH_TABLE_PARAM1"," 330 LECTURE NBC=0");

                vbd=1;

                this.majBaseDeDonnees(context,db,vbd);
                //Log.d("RECH_TABLE_PARAM1"," 335");

                vbd=2;
                this.majBaseDeDonnees(context,db,vbd);
                //Log.d("RECH_TABLE_PARAM1"," 339");

                vbd=3;
                this.majBaseDeDonnees(context,db,vbd);
                //Log.d("RECH_TABLE_PARAM1"," 343");


                vbd=4;
                this.majBaseDeDonnees(context,db,vbd);
                //Log.d("RECH_TABLE_PARAM1"," 348");t


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
            //Log.v("RECH_TABLE_PARAM1","ERREUR 378 ");

            //db.execSQL("DROP TABLE IF EXISTS " + TABLE_PARAM);

            db.execSQL(TABLE_CREATE_PARAM);

            //Log.v("MYSQLHELPER TABLE_CREATE_PARAM",TABLE_CREATE_PARAM);

            //Log.v("MYSQLHELPER"," 388");
            this.majBaseDeDonnees(context,db,1);
            //Log.v("MYSQLHELPER"," 390");
            this.majBaseDeDonnees(context,db,2);
            //Log.v("MYSQLHELPER"," 392");
            this.majBaseDeDonnees(context,db,3);
            //Log.v("MYSQLHELPER"," 394");
            this.majBaseDeDonnees(context,db,4);
            //Log.v("MYSQLHELPER"," 396");

            //Log.d("CtrlVBD","333");


            //String smode=PARAM_MODEENCOURS_LISTE;

            //Param nparam = new Param(0,versionBd,smode);

            //Log.d("ERREURCONTROLEVERSIONBD"," ERREURSTRING  "+e.toString()+" CAUSE "+e.getCause());
            //Log.d("ERREURCONTROLEVERSIONBD"," RECHERCHE  "+e.getMessage());
/**/


           // newParam.setversionBd(1);
            vbd=1;
           // newParam.setModeencours(MySQLiteHelper.PARAM_MODEENCOURS_LISTE);

            ParamDataSource pds = new ParamDataSource(context);
            pds.open();
            //Log.v("MYSQLHELPER"," 416");
            newParam=pds.createParam(vbd,MySQLiteHelper.PARAM_MODEENCOURS_LISTE,0);
            //Log.v("MYSQLHELPER"," 418");

            /* idparam=newParam.getId(); */

            //Log.d("ERREURCONTROLEVERSIONBD",TABLE_CREATE_PARAM+" IDPARAM="+idparam);

            pds.close();

        }


       //Log.d("RECH_TABLE_PARAM2"," 428, RECHERCHE  2 VERSION BASE DE DONNEES "+vbd);

        return vbd;
    }

    public void majBaseDeDonnees(Context context,SQLiteDatabase db,int version)
    {
        //Param param = new Param();

       //Log.d("majBaseDeDonnees", "427 version "+ version);

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

                String sqlparam= "ALTER TABLE "+TABLE_PARAM+" ADD COLUMN "+PARAM_COLUMN_MODECONTROLE+" INTEGER DEFAULT 0";
                String sqlparam2 = "ALTER TABLE "+TABLE_PARAM+" ADD COLUMN "+PARAM_COLUMN_LISTEENCOURS+" STRING DEFAULT '';";

                String sqlalterart = "ALTER TABLE "+TABLE_ARTICLES+" DROP COLUMN "+COLUMN_PUHT;

                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_TXTVA;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_PUTTC;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_QTE;

                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_DSLISTE;
                sqlalterart = sqlalterart + " DROP COLUMN "+COLUMN_DSACHATS;

                //String sqlalterparam = "ALTER TABLE "+TABLE_PARAM+" DROP COLUMN "+PARAM_COLUMN_MODECONTROLE;
                //sqlalterparam=sqlalterparam+ "ALTER TABLE "+TABLE_PARAM+" DROP COLUMN "+PARAM_COLUMN_FAMENCOURS;

                //Log.v("MYSQLHELPER","543");
                //Log.v("MYSQLHELPER maj table PARAM ",sqlparam);

                try {
                    db.execSQL(sqlart);
                    db.execSQL(sqlparam);
                    db.execSQL(sqlparam2);


                    //db.execSQL(sqlalterart);
                    //db.execSQL(sqlalterparam);

                    this.MiseAJourParamVersionBase(context,db,3);


                }catch (SQLiteException e)
                {
                    //Log.d("ERREUR MAJVBD",e.getMessage().toString());
                    //Log.v("MYSQLHELPER","ERREUR 572");

                }

                break;
            case 4:
                sqlparam= "ALTER TABLE "+TABLE_PARAM+" ADD COLUMN "+PARAM_COLUMN_FAMENCOURS+" LONG DEFAULT 0;";
                try {
                    db.execSQL(sqlparam);
                    Toast.makeText(context,sqlparam,Toast.LENGTH_LONG).show();


                    //db.execSQL(sqlalterart);
                    //db.execSQL(sqlalterparam);

                    this.MiseAJourParamVersionBase(context,db,4);


                }catch (SQLiteException e)
                {
                    //Log.d("ERREUR MAJVBD",e.getMessage().toString());

                }
            default:
                break;
        }
       //Log.d("majBaseDeDonnees", "585");

    }

    public void MiseAJourParamVersionBase(Context context,SQLiteDatabase db,int version)
    {
        Param param = new Param();

        ParamDataSource pds = new ParamDataSource(context);
        pds.open();

       // String[] allColumns = { MySQLiteHelper.COLUMN_ID,
        //        MySQLiteHelper.PARAM_COLUMN_VBD,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS };

        String[] allColumns = { MySQLiteHelper.COLUMN_ID,
                MySQLiteHelper.PARAM_COLUMN_VBD
                ,MySQLiteHelper.PARAM_COLUMN_MODEENCOURS
                ,MySQLiteHelper.PARAM_COLUMN_MODECONTROLE
                ,MySQLiteHelper.PARAM_COLUMN_LISTEENCOURS
                ,MySQLiteHelper.PARAM_COLUMN_FAMENCOURS};

       //Log.d("MiseAJourParamVersionBase", "599");


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
       //Log.d("MiseAJourParamVersionBase", "637");

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
