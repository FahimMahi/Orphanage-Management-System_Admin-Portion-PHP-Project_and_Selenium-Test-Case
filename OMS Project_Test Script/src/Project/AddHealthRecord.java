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

public class AddHealthRecord {
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

            // Step 2: Navigate to the Health Records page
            driver.navigate().to("http://localhost:8080/Orphanage-Management-System/Views/health_records.php");
            wait.until(ExpectedConditions.presenceOfElementLocated(By.tagName("body")));
            System.out.println("Navigation to Health Records Page: Passed");

            // Step 3: Fill out the "Add Health Record" form
            WebElement childSelect = wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("child_id")));
            childSelect.sendKeys("1"); // Replace with a valid child ID

            WebElement medicalHistoryField = driver.findElement(By.id("medical_history"));
            medicalHistoryField.sendKeys("No prior issues.");

            WebElement vaccinationsField = driver.findElement(By.id("vaccinations"));
            vaccinationsField.sendKeys("COVID-19, Flu");

            WebElement treatmentsField = driver.findElement(By.id("treatments"));
            treatmentsField.sendKeys("Antibiotics");

            WebElement lastCheckupField = driver.findElement(By.id("last_checkup"));
            lastCheckupField.sendKeys("01-12-2023"); // Last Checkup Date

            WebElement nextAppointmentField = driver.findElement(By.id("next_appointment"));
            nextAppointmentField.sendKeys("15-01-2024"); // Next Appointment Date

            // Step 4: Submit the form
            WebElement submitButton = driver.findElement(By.xpath("//input[@type='submit' and @value='Add Health Record']"));
            submitButton.click();

            // Step 5: Handle the success alert
            Alert alert = wait.until(ExpectedConditions.alertIsPresent());
            System.out.println("Alert Text: " + alert.getText());
            alert.accept(); // Accept the alert

            // Step 6: Verify the new health record in the table
            WebElement recordTable = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//table/tbody")));
            String tableContent = recordTable.getText(); // Retrieve the full table content as text

            if (tableContent.contains("1") &&
                tableContent.contains("No prior issues.") &&
                tableContent.contains("COVID-19, Flu") &&
                tableContent.contains("Antibiotics") &&
                tableContent.contains("2023-12-01") &&
                tableContent.contains("2024-01-15")) {
                System.out.println("Add Health Record Test: Passed - Health record successfully added.");
            } else {
                System.out.println("Add Health Record Test: Failed - Health record not found in the table.");
            }

        } catch (Exception e) {
            System.out.println("An error occurred: " + e.getMessage());
            e.printStackTrace();
        } finally {
            driver.quit();
        }
    }
}
