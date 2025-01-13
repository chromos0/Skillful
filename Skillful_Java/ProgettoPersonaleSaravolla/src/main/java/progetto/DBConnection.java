package progetto;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.sql.*;

public class DBConnection {

	private static final String DB_DRIVER = "org.mariadb.jdbc.Driver";
	private static final String DB_CONNECTION = "jdbc:mariadb://localhost/progetto_personale";
	
	private static final String DB_USER = "root";
	private static final String DB_PASSWORD = "";
	static Connection dbConnection = null;
	public DBConnection() {
		System.out.println("Inizio Connessione...");
		try {
			// The newInstance() call is a work around for some
			// broken Java implementations
			System.out.println("Cerco i driver...");
			Class.forName(DB_DRIVER);
			System.out.println("Driver NON trovati mannaggia (colpa di Stefano)");
		} catch (Exception ex) {
			// handle the error
			System.out.println("errore JDBC");
		}
		try
		{
			System.out.println("Provo a connettermi al Database...");
			dbConnection = DriverManager.getConnection(DB_CONNECTION, DB_USER, DB_PASSWORD);
			System.out.println("Connessione non eseguita! Stefano ti ha fatto sbalgiare tutto");
		}
		catch (SQLException e)
		{
			System.out.println("Connection to dbmio database failed");
			System.out.println(e.getErrorCode() + ":" + e.getMessage());
			// throw new SQLException(e.getErrorCode() + ":" + e.getMessage());
		}
	}
	
	public ResultSet QuerySelect(String query) {
		Statement stmt = null;
		try {
			stmt = dbConnection.createStatement();
			ResultSet result = stmt.executeQuery(query);
			return result;
		}
		catch(SQLException sqle)
		{
			System.out.println("SELECT ERROR");
			return null;
		}
		catch(Exception err)
		{
			System.out.println("GENERIC ERROR");
			return null;
		}
	}
}