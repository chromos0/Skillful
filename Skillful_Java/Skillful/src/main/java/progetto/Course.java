package progetto;

public class Course {
	private int id;
	private String name;
	private String creation_date;
	private String description;
	private int verified;
	private String folder;
	private int category;
	private int user_created;
	private int state;
	private String username;
	private float avgRating;
	private int nComments;
	private int nChapters;
	
	public Course(int id, String name, String creation_date, String description, int verified, String folder, int category, int user_created, int state, String username, float avgRating, int nComments, int nChapters) {
		setId(id);
		setName(name);
		setCreation_date(creation_date);
		setDescription(description);
		setVerified(verified);
		setFolder(folder);
		setCategory(category);
		setUser_created(user_created);
		setState(state);
		setUsername(username);
		setAvgRating(avgRating);
		setnComments(nComments);
		setnChapters(nChapters);
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getCreation_date() {
		return creation_date;
	}

	public void setCreation_date(String creation_date) {
		this.creation_date = creation_date;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public int getVerified() {
		return verified;
	}

	public void setVerified(int verified) {
		this.verified = verified;
	}

	public String getFolder() {
		return folder;
	}

	public void setFolder(String folder) {
		this.folder = folder;
	}

	public int getCategory() {
		return category;
	}

	public void setCategory(int category) {
		this.category = category;
	}

	public int getUser_created() {
		return user_created;
	}

	public void setUser_created(int user_created) {
		this.user_created = user_created;
	}

	public int getState() {
		return state;
	}

	public void setState(int state) {
		this.state = state;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public float getAvgRating() {
		return avgRating;
	}

	public void setAvgRating(float avgRating) {
		this.avgRating = avgRating;
	}

	public int getnComments() {
		return nComments;
	}

	public void setnComments(int nComments) {
		this.nComments = nComments;
	}

	public int getnChapters() {
		return nChapters;
	}

	public void setnChapters(int nChapters) {
		this.nChapters = nChapters;
	}
}
