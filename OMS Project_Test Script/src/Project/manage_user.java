package Project;

import org.openqa.selenium.Alert;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class manage_user {
    public static void main(String[] args) {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Step 1: Navigate to Login Page
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            // Step 2: Perform Login
            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com");

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123");

            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            submitButton.click();

            // Step 3: Verify Login and Navigate to Dashboard
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));
            System.out.println("Login Test: Passed");

            // Step 4: Navigate to Manage Users Page
            WebElement manageUsersLink = wait.until(ExpectedConditions.visibilityOfElementLocated(By.linkText("Manage Users")));
            manageUsersLink.click();

            String expectedManageUsersUrl = "http://localhost:8080/Orphanage-Management-System/Views/manage_users.php";
            wait.until(ExpectedConditions.urlToBe(expectedManageUsersUrl));
            System.out.println("Navigation to Manage Users: Passed");

            // Step 5: Add a New User
            WebElement usernameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("username")));
            usernameField.sendKeys("Jakia Sultana Mim");

            WebElement emailInput = driver.findElement(By.id("email"));
            emailInput.sendKeys("jakiamim@gmail.com");

            WebElement passwordInput = driver.findElement(By.id("password"));
            passwordInput.sendKeys("password123");

            WebElement roleSelect = driver.findElement(By.id("role"));
            roleSelect.sendKeys("Admin"); // Select role

            WebElement addUserButton = driver.findElement(By.name("add_user"));
            addUserButton.click();

            // Step 6: Handle Alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Click "OK" on the alert

            // Step 7: Verify User Addition in Table
            WebElement userTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = userTable.getText();

            if (tableContent.contains("Jakia Sultana Mim") &&
                tableContent.contains("jakiamim@gmail.com") &&
                tableContent.contains("Admin")) {
                System.out.println("Add User Test: Passed");
            } else {
                System.out.println("Add User Test: Failed");
            }
        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
        } finally {
            driver.quit();
        }
    }
}
