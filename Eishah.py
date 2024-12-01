
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import mysql.connector
from mysql.connector import Error
#from selenium.webdriver.chrome.service import Service as ChromeService
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import difflib

import requests
from selenium.webdriver.chrome.options import Options
from datetime import datetime, date

def translate_text(text, target_language):
    api_url = f"https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl={target_language}&dt=t&q={text}"
    response = requests.get(api_url)

    if response.status_code == 200:
        # Parse the response and extract the translated text
        data = response.json()
        translated_text = data[0][0][0]
        return translated_text
    else:
        # Handle errors
        return None



def scrape_events():
    binary_location = "/opt/google/chrome/google-chrome"
    options = Options()
    options.binary_location = binary_location
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--headless')

    service = Service("/usr/bin/chromedriver")
    driver = webdriver.Chrome(service=service, options=options)

    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="admin_user",
            password="E@vnT87023",
            database="events"
        )

        if connection.is_connected():
            db_Info = connection.get_server_info()
            print(f"Connected to MySQL Server version {db_Info}")

            for page_num in range(1, 7):  # Loop through pages
                cursor = connection.cursor()  # Open a new cursor for each page
                url = f"https://enjoy.sa/en/events/?page={page_num}"
                driver.get(url)

                wait = WebDriverWait(driver, 10)
                wait.until(EC.presence_of_all_elements_located((By.CLASS_NAME, "card-event")))

                event_cards = driver.find_elements(By.CLASS_NAME, "card-event")

                for card in event_cards:
                    location = card.find_element(By.CSS_SELECTOR, ".card-location .location").text.strip()
                    location_ar = translate_text(location, 'ar')

                    location_str = card.find_element(By.CSS_SELECTOR, ".card-location .location")
                    try:
                        labels = location_str.find_elements(By.CSS_SELECTOR, "label")
                        city_str = labels[1].text.strip() if len(labels) > 1 else labels[0].text.strip()
                    except IndexError:
                        city_str = None


                    title = card.find_element(By.CSS_SELECTOR, ".title").text.strip()
                    details = card.find_element(By.CSS_SELECTOR, ".title").text.strip()

                    title_ar = translate_text(title, 'ar')

                    category = card.find_element(By.CSS_SELECTOR, ".category").text.strip()
                    category_ar = translate_text(category, 'ar')
                    cursor.execute("SELECT id FROM categories WHERE name = %s", (category,))
                    result = cursor.fetchone()

                    if result:
                        category_id = result[0]
                    else:
                        cursor.execute("INSERT INTO categories (name, name_ar) VALUES (%s, %s)", (category, category_ar))
                        connection.commit()
                        category_id = cursor.lastrowid

                    date_time_element = card.find_element(By.CSS_SELECTOR, ".date-time")
                    start_date_str = date_time_element.find_elements(By.CSS_SELECTOR, "i")[0].text.strip()
                    start_time_str = date_time_element.find_elements(By.CSS_SELECTOR, "i")[1].text.strip()
                    end_date_str = date_time_element.find_elements(By.CSS_SELECTOR, "i")[3].text.strip()
                    end_time_str = date_time_element.find_elements(By.CSS_SELECTOR, "i")[4].text.strip()
                    
                    start_date = datetime.strptime(start_date_str, "%b %d %Y").date()
                    start_time = datetime.strptime(start_time_str, "%I:%M %p").time()
                    end_date = datetime.strptime(end_date_str, "%b %d %Y").date()
                    end_time = datetime.strptime(end_time_str, "%I:%M %p").time()

                    url_element = card.find_element(By.CSS_SELECTOR, ".card-img")
                    event_url = url_element.get_attribute("href")
                    image_url = card.find_element(By.CSS_SELECTOR, "source").get_attribute("lazyload")

                    query = "INSERT INTO events (event_name, event_name_ar, category_id, event_image, event_details, location, location_ar, start_time, end_time, start_date, end_date, url) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
                    values = (title, title_ar, category_id, image_url, details, location, location_ar, start_time, end_time, start_date, end_date, event_url)

                    cursor.execute("SELECT COUNT(*) FROM events WHERE event_name = %s AND start_date = %s AND location = %s", (title, start_date, location))
                    existing_count = cursor.fetchone()[0]

                    if existing_count == 0:
                        cursor.execute(query, values)
                        connection.commit()
                    else:
                        print(f"Event with title '{title}', start date '{start_date}', and location '{location}' already exists in the database. Skipping insertion.")

                cursor.close()  # Close the cursor after processing the page
                print(f"Data from page {page_num} inserted successfully")

    except Error as e:
        print(f"Error connecting to the MySQL database: {e}")

    finally:
        if connection.is_connected():
            connection.close()
            print("MySQL connection is closed")
        driver.quit()

# Call the function
scrape_events()





