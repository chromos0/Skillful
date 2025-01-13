package progetto;

import java.io.File;
import java.io.IOException;
import java.net.http.HttpRequest;
import java.nio.channels.SelectableChannel;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Enumeration;
import java.util.UUID;

import javax.management.Query;
import javax.servlet.ServletException;
import javax.servlet.annotation.MultipartConfig;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.servlet.http.Part;

import org.springframework.boot.orm.jpa.hibernate.SpringImplicitNamingStrategy;

import com.fasterxml.jackson.annotation.JsonTypeInfo.Id;

import ch.qos.logback.core.encoder.EchoEncoder;

/**
 * Servlet implementation class CourseHandler
 */
@WebServlet("/CourseHandler")
@MultipartConfig
public class CourseHandler extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public CourseHandler() {
        super();
        // TODO Auto-generated constructor stub
    }

    DBConnection connection = new DBConnection();
    
	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		HttpSession session = request.getSession();
		
		Enumeration<String> parameterNames = request.getParameterNames();
        // Iterate over parameter names
		response.setContentType("text/plain");
		int elements = 0;
        while (parameterNames.hasMoreElements()) {
        	elements ++;
            String paramName = parameterNames.nextElement();
            // Get parameter value(s) for the current parameter name
            String[] paramValues = request.getParameterValues(paramName);
            // Print parameter name and value(s)
            response.getWriter().append(paramName + ": ");
            if (paramValues != null) {
                for (String paramValue : paramValues) {
                	response.getWriter().append(paramValue + ", ");
                }
            }
        }
        response.getWriter().append("parameters: " + elements + "\n");
		
		int courseid = 0;
		int userid = 0;
		int role = 0;
		int chapter = 1;
		if(session.getAttribute("user_id") != null) {
			userid = (int)session.getAttribute("user_id");
			role = (int)session.getAttribute("role");
		} else {
			response.getWriter().append("no logged user");
			response.sendRedirect("login.jsp");
		}
		String query;
		ResultSet result;
		if(request.getParameter("courseid") != null) {
			courseid = Integer.parseInt(request.getParameter("courseid"));
		} else {
			response.getWriter().append("no course id\n");
			response.sendRedirect("home.jsp");
		}
		if(request.getParameter("grantEditAccess") != null) {
			query = "SELECT * FROM courses_view WHERE id = " + courseid;
			result = connection.QuerySelect(query);
			try {
				if(result.next()) {
					if(result.getInt("user_created") == userid) {
						session.setAttribute("grantEditAccess", courseid);
						response.getWriter().append("granted normal edit access");
						response.sendRedirect("editCourse.jsp?courseId=" + courseid);
					} else {
						if(role == 1) {
							response.getWriter().append("admin access");
							session.setAttribute("grantEditAccess", courseid);
						} else {
							response.getWriter().append("no access");
							session.setAttribute("noAccess", courseid);
						}
						response.sendRedirect("editCourse.jsp?courseId=" + courseid);
					}
				} else {
					session.setAttribute("courseDoesntExist", courseid);
					response.sendRedirect("editCourse.jsp?courseId=" + courseid);
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		} else if(request.getParameter("grantViewAccess") != null) {
			if(request.getParameter("chapter") != null) {
				chapter = Integer.parseInt(request.getParameter("chapter"));
			} else {
				response.getWriter().append("no chapter\n");
				response.sendRedirect("home.jsp");
			}
			response.getWriter().append("asked for view access\n");
			query = "SELECT * FROM courses_view WHERE id = " + courseid;
			result = connection.QuerySelect(query);
			try {
				if(result.next()) {
					if(result.getInt("user_created") == userid || result.getInt("state") == 1) {
						session.setAttribute("grantViewAccess", courseid);
						response.getWriter().append("granted normal view access to course " + session.getAttribute("grantViewAccess"));
						response.sendRedirect("viewCourse.jsp?courseId=" + courseid + "&chapter=" + chapter);
					} else {
						if(role == 1) {
							session.setAttribute("grantViewAccess", courseid);
						} else {
							response.getWriter().append("no access");
							session.setAttribute("noAccess", courseid);
						}
						response.sendRedirect("viewCourse.jsp?courseId=" + courseid + "&chapter=" + chapter);
					}
				} else {
					session.setAttribute("courseDoesntExist", courseid);
					response.getWriter().append("no exist");
					response.sendRedirect("viewCourse.jsp?courseId=" + courseid + "&chapter=" + chapter);
				}
			} catch (SQLException e) {
				response.getWriter().append("error");
				e.printStackTrace();
			}
		} else {
			response.getWriter().append("no grantaccess\n");
			//response.sendRedirect("home.jsp");
		}
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		//Cambiare la directory
		String absolutePath = "C:/Users/sarav/eclipse-workspace/ProgettoPersonaleSaravolla/src/main/webapp/";
		// TODO Auto-generated method stub
		HttpSession session = request.getSession();
		int user_id = 0;
		if(session.getAttribute("user_id") == null) {
			response.sendRedirect("login.jsp");
		} else {
			user_id = (int)session.getAttribute("user_id");
		}
		Enumeration<String> parameterNames = request.getParameterNames();
        // Iterate over parameter names
		response.setContentType("text/plain");
		int elements = 0;
        while (parameterNames.hasMoreElements()) {
        	elements ++;
            String paramName = parameterNames.nextElement();
            // Get parameter value(s) for the current parameter name
            String[] paramValues = request.getParameterValues(paramName);
            // Print parameter name and value(s)
            response.getWriter().append(paramName + ": ");
            if (paramValues != null) {
                for (String paramValue : paramValues) {
                	response.getWriter().append(paramValue + ", ");
                }
            }
        }
        response.getWriter().append("parameters: " + elements + "\n");
        response.getWriter().append(request.getParameter("action") + "\n");
        response.getWriter().append(request.getParameter("addAnswer") + "\n");
        if(request.getParameter("action") != null) {
        if(request.getParameter("action").equals("creation")) {
        	String name = request.getParameter("name");
        	String description = request.getParameter("desc");
        	if(description == "") {
        		description = "No description added";
        	}
        	int category = Integer.parseInt(request.getParameter("category"));
        	Part thumbnail = request.getPart("thumbnail");
        	
        	//cambiare la directory
        	String relativeFolder = "assets/courses/" + UUID.randomUUID().toString() + "/";
        	absolutePath += relativeFolder;
        	String filename = "thumbnail.png";
        	Path directoryPath = Paths.get(absolutePath);
        	try {
        	    Files.createDirectories(directoryPath);
        	} catch (IOException e) {
        	    e.printStackTrace();
        	}
        	if(thumbnail.getSize() == 0) {
        		Path source = Paths.get("assets/defaults/defaultThumbnail.png");
        	    Path destination = Paths.get(absolutePath + "thumbnail.png");
        	    Files.copy(source, destination);
        	} else {
        		try {
            	    thumbnail.write(absolutePath + filename);
            	} catch (IOException e) {
            	    e.printStackTrace();
            	}
        	}
        	Path chapter1Path = Paths.get(absolutePath + "chapter1/");
        	try {
        	    Files.createDirectories(chapter1Path);
        	} catch (IOException e) {
        	    e.printStackTrace();
        	}
        	String query = "";
        	if(category == 0) {
        		query = "INSERT INTO courses(`name`, `description`, `folder`, `creation_date`, `user_created`) VALUES ('" + name + "', '" + description + "', '" + relativeFolder + "', CURRENT_TIMESTAMP, '" + user_id + "')";
        	} else {
        		query = "INSERT INTO courses(`name`, `description`, `folder`, `creation_date`, `user_created`, `category`) VALUES ('" + name + "', '" + description + "', '" + relativeFolder + "', CURRENT_TIMESTAMP, '" + user_id + "', '" + category + "')";
        		response.getWriter().append("\n" + query + "\n");
        	}
        	ResultSet result = connection.QuerySelect(query);
        	query = "SELECT id FROM courses WHERE folder = '" + relativeFolder + "'";
        	result = connection.QuerySelect(query);
        	try {
				if(result.next()) {
					int id = result.getInt("id");
					query = "INSERT INTO chapters (name, course_id, number) VALUES ('chapter1', " + id + ", 1)";
		        	try {
		        		result = connection.QuerySelect(query);
		        		response.sendRedirect("editCourse.jsp?courseId=" + id);
					} catch (Exception e) {
						e.printStackTrace();
					}
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
        } else if(request.getParameter("action").equals("editMainInfo")) {
        	int id = Integer.parseInt(request.getParameter("courseId"));
        	String name = request.getParameter("courseName");
        	String desc = request.getParameter("description");
        	Part thumbnail = request.getPart("thumbnail");
        	String folder = request.getParameter("folder");
        	if(thumbnail.getSize() > 0) {
        		try {
					thumbnail.write(folder + "thumbnail.png");
				} catch (Exception e) {
					e.printStackTrace();
				}
        	}
        	String query = "UPDATE courses SET name = '" + name + "', description = '" + desc + "' WHERE id = " + id;
        	try {
        		ResultSet result = connection.QuerySelect(query);
        		response.sendRedirect(request.getHeader("referer"));
			} catch (Exception e) {
				e.printStackTrace();
			}
        } else if(request.getParameter("action").equals("verification")) {
        	if(request.getParameter("publish") != null) {
        		int id = Integer.parseInt(request.getParameter("courseId"));
        		String query = "UPDATE courses SET state = 1 WHERE id = " + id;
        		try {
					ResultSet result = connection.QuerySelect(query);
					response.sendRedirect(request.getHeader("referer"));
				} catch (Exception e) {
					e.printStackTrace();
				}
        	} else if(request.getParameter("private") != null) {
        		int id = Integer.parseInt(request.getParameter("courseId"));
        		String query = "UPDATE courses SET state = 0, verified = 0 WHERE id = " + id;
        		try {
					ResultSet result = connection.QuerySelect(query);
					response.sendRedirect(request.getHeader("referer"));
				} catch (Exception e) {
					e.printStackTrace();
				}
        	} else if(request.getParameter("verify") != null) {
        		int id = Integer.parseInt(request.getParameter("courseId"));
        		String query = "UPDATE courses SET verified = 1 WHERE id = " + id;
        		try {
					ResultSet result = connection.QuerySelect(query);
					response.sendRedirect(request.getHeader("referer"));
				} catch (Exception e) {
					e.printStackTrace();
				}
        	} else if(request.getParameter("unverify") != null) {
        		int id = Integer.parseInt(request.getParameter("courseId"));
        		String query = "UPDATE courses SET verified = 0 WHERE id = " + id;
        		try {
					ResultSet result = connection.QuerySelect(query);
					response.sendRedirect(request.getHeader("referer"));
				} catch (Exception e) {
					e.printStackTrace();
				}
        	}
        } else if(request.getParameter("action").equals("addChapter")) {
        	int id = Integer.parseInt(request.getParameter("courseId"));
        	int chaptersNumber = Integer.parseInt(request.getParameter("chaptersNumber"));
        	String folder = request.getParameter("folder");
        	Path chapterPath = Paths.get(absolutePath + folder + "chapter" + chaptersNumber + "/");
        	try {
        	    Files.createDirectories(chapterPath);
        	} catch (IOException e) {
        	    e.printStackTrace();
        	}
        	String query = "INSERT INTO chapters(`course_id`, `number`) VALUES (" + id + ", " + chaptersNumber + ")";
        	try {
				ResultSet result = connection.QuerySelect(query);
				response.sendRedirect(request.getHeader("referer"));
			} catch (Exception e) {
				e.printStackTrace();
			}
        } else if(request.getParameter("action").equals("removeChapter")) {
        	String folder = request.getParameter("folder");
        	int chapterId = Integer.parseInt(request.getParameter("chapterId"));
        	int chapterNumber = Integer.parseInt(request.getParameter("chapterNumber"));
        	String query = "DELETE FROM chapters WHERE id = " + chapterId;
        	try {
				ResultSet result = connection.QuerySelect(query);
			} catch (Exception e) {
				e.printStackTrace();
			}
        	String pathString = absolutePath + folder + "chapter" + chapterNumber;
        	response.getWriter().append(pathString);
        	File folderPath = new File(pathString);
        	deleteFolder(folderPath);
        	response.sendRedirect(request.getHeader("referer"));
        } else if(request.getParameter("action").equals("deleteCourse")) {
        	String query = "DELETE FROM courses WHERE id = " + request.getParameter("deleteCourse");
        	response.getWriter().append(query);
        	try {
				ResultSet result = connection.QuerySelect(query);
				String folder = request.getParameter("folder");
				folder = folder.substring(0, folder.length() - 1);
				File folderPath = new File(absolutePath + folder);
				deleteFolder(folderPath);
				response.sendRedirect("home.jsp");
			} catch (Exception e) {
				e.printStackTrace();
			}
        } else if(request.getParameter("action").equals("updateChapter")) {
        	String folder = request.getParameter("folder");
        	String name = request.getParameter("chapterName");
        	Part presentation = request.getPart("presentation");
        	int chapterId = Integer.parseInt(request.getParameter("chapterId"));
        	String query = "UPDATE chapters SET name = '" + name + "' WHERE id = " + chapterId;
        	try {
        		ResultSet result = connection.QuerySelect(query);
			} catch (Exception e) {
				// TODO: handle exception
				e.printStackTrace();
			}
        	String chapterPath = absolutePath + folder;
        	if(presentation.getSize() > 0) {
        		try {
            	    presentation.write(chapterPath + "presentation.pdf");
            	} catch (IOException e) {
            	    e.printStackTrace();
            	}
        	}
        	response.sendRedirect(request.getHeader("referer"));
        }
        } else {
        	if(request.getParameter("addQuestion") != null) {
            	int courseId = Integer.parseInt(request.getParameter("addQuestion"));
            	String query = "INSERT INTO questions (`id_course`) VALUES ('" + courseId + "')";
            	try {
            		updateQuiz(request);
    				ResultSet result = connection.QuerySelect(query);
    				response.sendRedirect(request.getHeader("referer"));
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
            } else if(request.getParameter("deleteQuestion") != null) {
            	int questionId = Integer.parseInt(request.getParameter("deleteQuestion"));
            	String query = "DELETE FROM questions WHERE id = " + questionId;
            	try {
            		updateQuiz(request);
    				ResultSet result = connection.QuerySelect(query);
    				response.sendRedirect(request.getHeader("referer"));
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
            } else if(request.getParameter("addAnswer") != null) {
            	int questionId = Integer.parseInt(request.getParameter("addAnswer"));
            	String query = "INSERT INTO answers (`id_question`) VALUES ('" + questionId + "')";
            	try {
            		updateQuiz(request);
    				ResultSet result = connection.QuerySelect(query);
    				response.sendRedirect(request.getHeader("referer"));
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
            } else if(request.getParameter("deleteAnswer") != null) {
            	int answerId = Integer.parseInt(request.getParameter("deleteAnswer"));
            	String query = "DELETE FROM answers WHERE id = " + answerId;
            	try {
            		updateQuiz(request);
    				ResultSet result = connection.QuerySelect(query);
    				response.sendRedirect(request.getHeader("referer"));
    			} catch (Exception e) {
    				e.printStackTrace();
    			}
            } else if(request.getParameter("updateQuiz") != null) {
            	updateQuiz(request);
            	response.sendRedirect(request.getHeader("referer"));
            } else if(request.getParameter("quizSubmission") != null) {
            	int nQuestions = Integer.parseInt(request.getParameter("nQuestions"));
            	int course_id = Integer.parseInt(request.getParameter("course_id"));
            	int score = 0;
            	String query;
            	ResultSet result;
            	for(int i = 0; i < nQuestions; i++) {
            		if(request.getParameter("selectedAnswer" + i) != null) {
            			query = "SELECT correct FROM answers WHERE id = " + Integer.parseInt(request.getParameter("selectedAnswer" + i));
                		result = connection.QuerySelect(query);
                		try {
    						if(result.next()) {
    							if(result.getInt("correct") == 1) {
    								score++;
    							}
    						}
    					} catch (SQLException e) {
    						e.printStackTrace();
    					}
            		}
            	}
            	query = "INSERT INTO exams (`examScore`,`id_course`,`id_user`, `date_done`) VALUES ('" + score + "', " + course_id + ", " + user_id + ", CURRENT_TIMESTAMP)";
            	try {
					result = connection.QuerySelect(query);
					response.sendRedirect(request.getHeader("referer"));
				} catch (Exception e) {
					e.printStackTrace();
				}
            }
        }
	}

	public static void updateQuiz(HttpServletRequest request) {
		DBConnection connection = new DBConnection();
		int courseId = Integer.parseInt(request.getParameter("courseId"));
		String query = "SELECT count(*) FROM questions WHERE id_course = " + courseId;
		ResultSet result = connection.QuerySelect(query);
		int nQuestions = 0;
		try {
			if(result.next()) {
				nQuestions = result.getInt(1);
			}
		} catch (SQLException e) {
			// TODO: handle exception
			e.printStackTrace();
		}
		for(int i = 0; i < nQuestions; i++) {
			int questionId = Integer.parseInt(request.getParameter("questionId" + i));
			String question = request.getParameter("question" + i);
			query = "UPDATE questions SET question = '" + question + "' WHERE id = " + questionId;
			try {
				result = connection.QuerySelect(query);
				query = "SELECT count(*) FROM answers WHERE id_question = " + questionId;
				result = connection.QuerySelect(query);
				int nAnswers = 0;
				if(result.next()) {
					nAnswers = result.getInt(1);
				}
				for(int j = 0; j < nAnswers; j++) {
					int answerId = Integer.parseInt(request.getParameter("answerId" + j + "question" + i));
					String answer = request.getParameter("answer" + j + "question" + i);
					int correct = 0;
					if(request.getParameter("rightAnswerForQuestion" + i) == null) {
						if(j == 0) {
							correct = 1;
						}
					} else {
						if(Integer.parseInt(request.getParameter("rightAnswerForQuestion" + i)) == j) {
							correct = 1;
						}
					}
					query = "UPDATE answers SET answer = '" + answer + "', correct = " + correct + " WHERE id=" + answerId;
					try {
						result = connection.QuerySelect(query);
					} catch (Exception e) {
						e.printStackTrace();
					}
				}
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
	}

    public static void deleteFolder(File folder) {
        if (folder.isDirectory()) {
            File[] files = folder.listFiles();
            if (files != null) {
                for (File file : files) {
                    deleteFolder(file);
                }
            }
        }
        folder.delete();
    }
}
