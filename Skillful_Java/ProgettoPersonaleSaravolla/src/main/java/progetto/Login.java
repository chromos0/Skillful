package progetto;

import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintWriter;
import java.nio.file.Files;
import java.nio.file.StandardCopyOption;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.UUID;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Base64;
import java.util.Enumeration;
import java.util.Map;

//import org.mindrot.jbcrypt.BCrypt;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.annotation.MultipartConfig;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import javax.servlet.http.Part;

/**
 * Servlet implementation class Login
 */
@WebServlet("/Login")
@MultipartConfig
public class Login extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public Login() {
        super();
        // TODO Auto-generated constructor stub
    }
    
    DBConnection connection = new DBConnection();
    HttpSession session;

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.setContentType("text/html");
		response.getWriter().append("<h1>" + request.getParameter("logType") + "</h1>");
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		HttpSession session = request.getSession();
		
		//Cambiare la directory
		String absolutePath = "C:/Users/sarav/eclipse-workspace/ProgettoPersonaleSaravolla/src/main/webapp/";
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
		response.getWriter().append(request.getParameter("logType") + "\n");
		if(request.getParameter("logType").equals("login")) {
			String username = request.getParameter("username");
			String psw = request.getParameter("psw");
			String query = "SELECT * FROM users WHERE username = '" + username + "' AND password = SHA1('" + psw + "')";
			response.getWriter().append("\n" + query + "\n");
			ResultSet results = connection.QuerySelect(query);
			try {
				while(results.next()) {
					response.getWriter().append("\n" + results.getString("username") + "\n");
					if(results.getString("username").equals(username)) {
						session.setAttribute("user_id", results.getInt("id"));
						session.setAttribute("pfp", results.getString("pfp"));
						session.setAttribute("role", results.getInt("role"));
						response.sendRedirect("home.jsp");
					}
				}	
			} catch (SQLException e) {
				// TODO: handle exception
				response.getWriter().append("ERRORE");
				e.printStackTrace();
			}
			//response.sendRedirect("login.jsp");
		} else if(request.getParameter("logType").equals("signup")) {
			String username = request.getParameter("username");
			String email = request.getParameter("email");
			String password = request.getParameter("psw");
			boolean usernameUsed = false;
			boolean emailUsed = false;
			String query = "SELECT username, email FROM users WHERE username = '" + username + "'";
			ResultSet result = connection.QuerySelect(query);
			try {
				while(result.next()) {
					if(result.getString("username").equals(username)) {
						System.out.println("username already used");
						usernameUsed = true;
						break;
					}
					if(result.getString("email").equals(username)) {
						System.out.println("email already used");
						emailUsed = true;
						break;
					}
				}
			}
			catch(SQLException sqle)
			{
				System.out.println("QUERY ERROR");
			}
			if(!usernameUsed && !emailUsed) {
				query = "INSERT into users(`username`, `password`, `email`) VALUES ('" + username + "', SHA1('" + password + "'), '" + email + "')";
				result = connection.QuerySelect(query);
				query = "SELECT id, username FROM users WHERE username = '" + username + "'";
				result = connection.QuerySelect(query);
				int userId = 0;
				String pfp = "";
				int role = 0;
				try {
					while(result.next()) {
						if(result.getString("username").equals(username)) {
							userId = result.getInt("id");
							role = result.getInt("role");
							break;
						}
					}
				} catch (SQLException sqle) {
					// TODO: handle exception
				}
				
				session.setAttribute("user_id", userId);
				session.setAttribute("role", role);
				session.setAttribute("username", username);
				response.sendRedirect("customize.jsp");
			} else {
				response.sendRedirect("signup.jsp");
			}
			} else if(request.getParameter("logType").equals("customize")) {
				int user_id = (int)session.getAttribute("user_id");
				String query = "SELECT username FROM users WHERE id = " + user_id;
				ResultSet resultUser = connection.QuerySelect(query);
				String username = "";
				try {
					if(resultUser.next()) {
						username = resultUser.getString("username");
					}
				} catch (Exception e) {
					// TODO: handle exception
					e.printStackTrace();
				}
				String aboutMe = request.getParameter("aboutMe");
				Part profilePic = request.getPart("pfp");
				String path = "";
				String relativePath = "";
				if(profilePic.getSize() == 0) {
					relativePath = "assets/defaults/defaultPFP.png";
				} else {
					String dir = absolutePath + "assets/usersPics/";
			        String fileName = username + "_" + UUID.randomUUID().toString() + ".png";
			        path = dir + fileName;
			        relativePath = "assets/usersPics/" + fileName;
			        try{
			        	profilePic.write(path);
					} catch (IOException e) {
						path = "assets/defaults/defaultPFP.png";
						e.printStackTrace();
					}
				}
				if(!aboutMe.isEmpty()) {
					query = "UPDATE users SET bio = '" + aboutMe + "', pfp = '" + relativePath + "' WHERE id = '" + user_id + "'";
					connection.QuerySelect(query);
				} else {
					query = "UPDATE users SET pfp = '" + relativePath + "' WHERE id = '" + user_id + "'";
					connection.QuerySelect(query);
				}
				session.setAttribute("pfp", relativePath);
				response.sendRedirect("home.jsp");
			} else if(request.getParameter("logType").equals("update")){
				int user_id = 0;
				if(session.getAttribute("user_id") == null) {
					response.sendRedirect("login.jsp");
				} else {
					user_id = (int)session.getAttribute("user_id");
				}
				Part profilePic = request.getPart("profilePic");
				String pfpPath = request.getParameter("pfpPath");
				String username = request.getParameter("username");
				String path = "";
				String relativePath = "";
				
				//Cambiare la directory
				if(profilePic.getSize() > 0) {
					if(pfpPath.equals("assets/defaults/default.png")) {
						//Cambiare la directory
				        String fileName = username + "_" + UUID.randomUUID().toString() + ".png";
				        path = absolutePath + "assets/usersPics/" + fileName;
				        relativePath = "assets/usersPics/" + fileName;
				        try{
				        	profilePic.write(path);
						} catch (IOException e) {
							e.printStackTrace();
						}
					} else {
						path = absolutePath + pfpPath;
						relativePath = pfpPath;
						try{
				        	profilePic.write(path);
						} catch (IOException e) {
							e.printStackTrace();
						}
					}
					response.getWriter().append(path);
				} else {
					relativePath = pfpPath;
				}
				String aboutMe = request.getParameter("bio");
				session.setAttribute("pfp", relativePath);
				String query = "UPDATE users SET bio = '" + aboutMe + "', pfp = '" + relativePath + "', username = '" + username + "' WHERE id = " + user_id;
				try {
					ResultSet result = connection.QuerySelect(query);
					response.sendRedirect("viewProfile.jsp?userid=" + user_id);
				} catch (Exception e) {
					// TODO: handle exception
					e.printStackTrace();
				}
			} else {
				response.getWriter().append("\nnone");
		}
		
	}

}
