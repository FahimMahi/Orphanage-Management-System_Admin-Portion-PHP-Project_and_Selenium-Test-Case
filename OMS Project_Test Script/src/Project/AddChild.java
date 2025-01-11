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

public class AddChild {
    public static void main(String[] args) {
        System.setProperty("webdriver.chrome.driver", "C:\\Users\\h\\chromedriver-win64\\chromedriver.exe");
        ChromeOptions options = new ChromeOptions();
        options.addArguments("--remote-allow-origins=*");
        WebDriver driver = new ChromeDriver(options);

        try {
            // Step 1: Login to the system
            driver.get("http://localhost:8080/Orphanage-Management-System/Views/login.php");
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

            WebElement emailField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.name("email")));
            emailField.sendKeys("mahi@gmail.com"); 

            WebElement passwordField = driver.findElement(By.name("password"));
            passwordField.sendKeys("password123");

            WebElement loginButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Login']"));
            loginButton.click();

            // Verify login and navigate to the dashboard
            String expectedDashboardUrl = "http://localhost:8080/Orphanage-Management-System/Views/admin_dashboard.php";
            wait.until(ExpectedConditions.urlToBe(expectedDashboardUrl));
            System.out.println("Login Test: Passed");

            // Step 2: Navigate to the Child Records page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/child_records.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Child Records Page: Passed");

            // Step 3: Fill out the "Add Child" form
            WebElement firstNameField = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("first_name")));
            firstNameField.sendKeys("Luka");

            WebElement lastNameField = driver.findElement(By.id("last_name"));
            lastNameField.sendKeys("Modric");

            WebElement dobField = driver.findElement(By.id("date_of_birth"));
            dobField.sendKeys("05-05-2008"); 

            WebElement genderSelect = driver.findElement(By.id("gender"));
            genderSelect.sendKeys("Male"); // Select Gender

            WebElement admissionDateField = driver.findElement(By.id("admission_date"));
            admissionDateField.sendKeys("10-12-2018");

            // Step 4: Submit the form
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Add Child']"));
            submitButton.click();

            // Step 5: Handle the alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert to proceed

            // Step 6: Verify that the child is added to the table
            WebElement childTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = childTable.getText(); // Retrieve the full table content as text

            // Debugging: Print table content for verification
            System.out.println("Table Content: " + tableContent);

            // Verify if the table contains all the expected child details
            if (tableContent.contains("Luka") &&
                tableContent.contains("Modric") &&
                tableContent.contains("2008-05-05") && // Ensure this matches the table's date format
                tableContent.contains("Male") &&
                tableContent.contains("2018-12-10")) { // Ensure this matches the table's date format
                System.out.println("Add Child Test: Passed - Child successfully added to the table.");
            } else {
                System.out.println("Add Child Test: Failed - Child not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
