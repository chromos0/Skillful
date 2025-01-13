package progetto;

public class User {
	private int id;
	private String username;
	private String email;
	private String pfp;
	private String bio;
	private int role;
	private int score;
	
	public User(int id, String username, String email, String pfp, String bio, int role, int score) {
		setId(id);
		setUsername(username);
		setEmail(email);
		setPfp(pfp);
		setBio(bio);
		setRole(role);
		setScore(score);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
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

	public String getBio() {
		return bio;
	}

	public void setBio(String bio) {
		this.bio = bio;
	}

	public int getScore() {
		return score;
	}

	public void setScore(int score) {
		this.score = score;
	}
}
