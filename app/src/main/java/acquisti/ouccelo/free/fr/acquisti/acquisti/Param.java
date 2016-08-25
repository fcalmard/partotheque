package acquisti.ouccelo.free.fr.acquisti.acquisti;

import android.util.Log;

public class Param {

	private long id;
	private int versionbd;
	private String modeencours;
	private boolean bmodectrl;
    private Long listeencours;
    private Long familleEnCours;


	public Param(){}

    public Param(long id, int versionBd,String modeencours) {
        this.id = id;
        this.versionbd = versionBd;
        this.modeencours=modeencours;
    }
    /*
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
     */
    public Param(long id, int versionBd,String modeencours,int imodectrl,long llisteid,long lfamid) {
        this.id = id;
        this.versionbd = versionBd;
        this.modeencours=modeencours;
        this.bmodectrl=(imodectrl==1);
        this.listeencours=llisteid;
        this.familleEnCours=lfamid;
    }

	public long getId() {
		return id;
	}

	public void setId(long id) {
		this.id = id;
	}

	public int getversionBd() {
		return versionbd;
	}

	public void setversionBd(int versionBd) {
		this.versionbd = versionBd;
	}

	public void setModeencours(String mc)
	{
        //Log.v("CLASS PARAM","61 setModeencours="+mc);

        this.modeencours=mc.toUpperCase().trim();
	}

	public String getModeencours()
	{
        //Log.v("CLASS PARAM","68 getModeencours="+this.modeencours);

        return this.modeencours;
	}

	public void setBmodectrl(boolean bctrl)
	{
		this.bmodectrl=bctrl;
	}
	public boolean getBmodectrl()
	{
		return this.bmodectrl;
	}
/*
Mémorise famille selectinnonée

 */
	public Long getFamilleEnCours()
	{
		//Log.v("CLASS PARAM","62 GET IDFAMILLE="+this.familleEnCours.toString());
		return this.familleEnCours;

	}
	public void setFamilleEnCours(Long familleID)
	{
        this.familleEnCours=familleID;
        //Log.v("CLASS PARAM","74 PUT IDFAMILLE="+this.getFamilleEnCours().toString());

	}

	@Override
	public String toString() {
		return "version bd:"+this.versionbd+" mode en cours :"+this.modeencours+" familleEnCours="+this.familleEnCours;
	}

}
