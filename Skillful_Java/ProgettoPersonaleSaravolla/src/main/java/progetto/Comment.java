package progetto;

public class Comment {
	private int id;
	private String comment;
	private float rating;
	private int id_user;
	private String username;
	private String date_added;
	private String pfp;
	private int role;
	
	public Comment(int id, String comment, float rating, int id_user, String username, String date_added, String pfp, int role) {
		setId(id);
		setComment(comment);
		setRating(rating);
		setId_user(id_user);
		setUsername(username);
		setDate_added(date_added);
		setPfp(pfp);
		setRole(role);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getComment() {
		return comment;
	}

	public void setComment(String comment) {
		this.comment = comment;
	}

	public float getRating() {
		return rating;
	}

	public void setRating(float rating) {
		this.rating = rating;
	}

	public int getId_user() {
		return id_user;
	}

	public void setId_user(int id_user) {
		this.id_user = id_user;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getDate_added() {
		return date_added;
	}

	public void setDate_added(String date_added) {
		this.date_added = date_added;
	}

	public String getPfp() {
		return pfp;
	}

	public void setPfp(String pfp) {
		this.pfp = pfp;
	}

	public int getRole() {
		return role;
	}

	public void setRole(int role) {
		this.role = role;
	}
}
