package acquisti.ouccelo.free.fr.acquisti.acquisti;
public class Param {

	private long id;
	private int versionbd;
	private String modeencours;


	public Param(){}

	public Param(long id, int versionBd,String modeencours) {
		this.id = id;
		this.versionbd = versionBd;
		this.modeencours=modeencours;
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

	public void setModeencours(String modeencours)
	{
		this.modeencours=modeencours.toUpperCase().trim();
	}

	public String getModeencours()
	{
		return this.modeencours;
	}

	@Override
	public String toString() {
		return "version bd:"+this.versionbd+" mode en cours :"+this.modeencours;
	}

}
