package acquisti.ouccelo.free.fr.acquisti.acquisti;

public class Article {

	private long id;
	private String libelle;
	private long FamilleId;	

	public Article(){}

	public Article(long id, String libelle,long FamilleId) {
		this.id = id;
		this.libelle = libelle;
		this.FamilleId = FamilleId;
	}

	public long getId() {
		return id;
	}

	public void setId(long id) {
		this.id = id;
	}

	public String getLibelle() {
		return libelle;
	}

	public void setLibelle(String libelle) {
		this.libelle = libelle;
	}
	public long getFamilleId() {
		return this.FamilleId;
	}

	public void setFamilleId(long FamilleId) {
		this.FamilleId = FamilleId;
	}

	@Override
	public String toString() {
		return this.libelle;
	}

}
