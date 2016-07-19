package acquisti.ouccelo.free.fr.acquisti.acquisti;
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import java.util.ArrayList;
import java.util.List;

public class ArticleDataSource {

	// Database fields
	private SQLiteDatabase database;
	private MySQLiteHelper dbHelper;
	private String[] allColumns = { MySQLiteHelper.COLUMN_ID,
			MySQLiteHelper.COLUMN_LIBELLE,MySQLiteHelper.COLUMN_ID_FAMILLE };

	public ArticleDataSource(Context context) {
		dbHelper = new MySQLiteHelper(context);
	}

	public void open() throws SQLException {
		database = dbHelper.getWritableDatabase();

	}

	public void close() {
		dbHelper.close();
	}

	/*

	 */
	public Article createArticle(Article article) {
		ContentValues values = new ContentValues();
/*

 */
		String libelle;
		long familleId;

        Article newArticle = new Article();


        /*values.put(MySQLiteHelper.COLUMN_LIBELLE, libelle);
        values.put(MySQLiteHelper.COLUMN_ID_FAMILLE,familleId);*/
		values.put(MySQLiteHelper.COLUMN_LIBELLE, article.getLibelle());
		values.put(MySQLiteHelper.COLUMN_ID_FAMILLE, article.getFamilleId());

        Log.d("TEST","insertion ARTICLE "+article.getLibelle());
        try{

            //database.beginTransaction();

            long insertId = database.insert(MySQLiteHelper.TABLE_ARTICLES, null,
                    values);
            if(insertId!=0)
            {
                Cursor cursor = database.query(MySQLiteHelper.TABLE_ARTICLES,
                        allColumns, MySQLiteHelper.COLUMN_ID + " = " + insertId, null,
                        null, null, null);

                cursor.moveToFirst();
                newArticle = cursorToArticle(cursor);
                cursor.close();
            }else
            {
                throw new Exception(" PROBLEME NOUVEAU ARTICLE");
            }


            //database.endTransaction();
        }

        catch(Exception e)
        {
            Log.i("TABLE_ARTICLES", "********************Exception onCreate() exception");
            String message = e.getMessage();

            //database.endTransaction();
      }finally {
            //database.endTransaction();

        }




		return newArticle;
	}
	
	public void updateArticle(Article article){
		ContentValues values = new ContentValues();

        values.put(MySQLiteHelper.COLUMN_LIBELLE, article.getLibelle());
        values.put(MySQLiteHelper.COLUMN_ID_FAMILLE, article.getFamilleId());

		database.update(MySQLiteHelper.TABLE_ARTICLES, values,
				MySQLiteHelper.COLUMN_ID + " = ? ",
				new String[] { String.valueOf(article.getId()) });
	}

	public void deleteArticle(Article article) {
		long id = article.getId();
		database.delete(MySQLiteHelper.TABLE_ARTICLES,
				MySQLiteHelper.COLUMN_ID + " = " + id, null);
	}

	public List<Article> getAllArticles(long ifam) {
		List<Article> articles = new ArrayList<Article>();

		Cursor cursor;

		if (ifam!=0)
		{
			//TABLE_ARTICLES_FAMILLE
			cursor = database.query(MySQLiteHelper.TABLE_ARTICLES,allColumns,MySQLiteHelper.COLUMN_ID_FAMILLE+" = "+ifam,
					null,null,null,null,null);
		}else
		{
			cursor = database.query(MySQLiteHelper.TABLE_ARTICLES,
					allColumns, null, null, null, null, null);
		}


		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Article article = cursorToArticle(cursor);

			long ifam2=article.getFamilleId();
			articles.add(article);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return articles;
	}

	public List<Article> getAllArticles(String order) {

		List<Article> articles = new ArrayList<Article>();
//, null, null, null, null, null);
		Cursor cursor = database.query(MySQLiteHelper.TABLE_ARTICLES,
				allColumns,null,null,null,null,order);

		cursor.moveToFirst();
		while (!cursor.isAfterLast()) {
			Article article = cursorToArticle(cursor);
			articles.add(article);
			cursor.moveToNext();
		}
		// make sure to close the cursor
		cursor.close();
		return articles;

	}

	private Article cursorToArticle(Cursor cursor) {
		Article article = new Article();
        article.setId(cursor.getLong(0));
		article.setLibelle(cursor.getString(1));
        article.setFamilleId(cursor.getLong(2));
		return article;
	}


	public  void init()
	{
		//database.
       // MySQLiteHelper.onCreate(database); this.database
        this.open();
        this.dbHelper.onUpgrade(database,1,2);
        this.close();

       // database.execSQL("DROP TABLE IF EXISTS " + database.TABLE_ARTICLES);
       // database.execSQL("DROP TABLE IF EXISTS " + database.TABLE_FAMILLES);

	}

    public  SQLiteDatabase getDatabase()
    {
        return database;
    }
}
