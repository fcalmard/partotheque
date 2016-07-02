package acquisti.ouccelo.free.fr.acquisti.acquisti;

public class Famille {

	private long id;
	private String libelle;

	public Famille(){}

	public Famille(long id, String nom) {
		this.id = id;
		this.libelle = nom;
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

	@Override
	public String toString() {
		return this.libelle;
	}

}
