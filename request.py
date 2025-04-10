#!/usr/bin/python3
# this file is used to scrape the listings from the website spareroom.co.uk
# it uses the playwright library to scrape the listings
# it uses the regex library to extract the price, location, description and title from the html
from playwright.sync_api import sync_playwright
import re
import csv
import sys
import json
import os

def extract_price_from_html(html):
    match = re.search(r'£\s?\d+(?:,\d{3})?(?:\.\d{2})?\s*(?:pcm|pw)', html, re.IGNORECASE)
    return match.group(0).strip() if match else "Price not found"

def extract_location_from_html(html):
    match = re.search(r'<p class="listing-card__location">([^<]+)</p>', html)
    return match.group(1).strip() if match else "Location not found"

def extract_description_from_html(html):
    match = re.search(r'<p class="listing-card__short_description">([^<]+)</p>', html)
    return match.group(1).strip() if match else "Description not found"

def extract_title_from_html(html):
    match = re.search(r'<h2 class="listing-card__title">(.*?)</h2>', html)
    return match.group(1).strip() if match else "No title"

def scrape_spareroom_rooms(area='London', pages=5):


    results = []

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        for page_num in range(1, pages + 1):
            if page_num == 1:
                url = f'https://www.spareroom.co.uk/flatshare/{area}'
            else:
                url = f'https://www.spareroom.co.uk/flatshare/{area}/page{page_num}'

            print(f"🔍 Scraping Page {page_num}: {url}")
            page.goto(url, timeout=60000)
            
            try:
                page.wait_for_selector('.listing-result', timeout=10000)
            except:
                print(f"⚠️ No listings found on page {page_num}. Skipping...")
                continue

            listings = page.query_selector_all('.listing-result')

            for listing in listings:
                try:
                    html = listing.inner_html()

                    title = extract_title_from_html(html)
                    location = extract_location_from_html(html)
                    description = extract_description_from_html(html)
                    price = extract_price_from_html(html)

                    link_element = listing.query_selector('a')
                    link = link_element.get_attribute('href') if link_element else None
                    full_link = 'https://www.spareroom.co.uk' + link if link else 'No link'

                    results.append({
                        'Title': title,
                        'Price': price,
                        'Location': location,
                        'Description': description,
                        'Link': full_link
                    })

                except Exception as e:
                    print(f"❌ Error processing listing: {e}")
                    continue

        browser.close()
    return results

def export_to_csv(data, filename='spareroom_listings.csv'):
    keys = data[0].keys() if data else []
    with open(filename, 'w', newline='', encoding='utf-8') as csvfile:
        writer = csv.DictWriter(csvfile, fieldnames=keys)
        writer.writeheader()
        writer.writerows(data)
    print(f"✅ Data exported to {filename}")

def export_to_json(data, filename='spareroom_listings.json', city=None):
    # Ensure the spareroom/ folder exists
    folder_name = 'spareroom'
    os.makedirs(folder_name, exist_ok=True)

    # Adjust the filename if a city is provided
    if city:
        filename = f'spareroom_listings_{city.lower().replace(" ", "_")}.json'

    # Full path to save file inside 'spareroom/' folder
    json_path = os.path.join("spareroom/", filename)

    # Add city info to each listing
    if city:
        for listing in data:
            listing['SearchCity'] = city.lower()

    with open(json_path, 'w', encoding='utf-8') as jsonfile:
        json.dump(data, jsonfile, ensure_ascii=False, indent=4)

    print(f"✅ Data exported to {json_path}")
if __name__ == "__main__":
    cities = [
    "Birmingham", "Bristol", "Leeds", "London", "Central London", "East London",
    "North London", "North West London", "South East London", "South West London",
    "West London", "Manchester", "Bolton", "Oldham", "Stockport", "Warrington",
    "Wigan", "Bath", "Blackburn", "Blackpool", "Bournemouth", "Bradford", "Brighton",
    "Bromley", "Cambridge", "Canterbury", "Carlisle", "Chelmsford", "Chester",
    "Cleveland", "Colchester", "Coventry", "Crewe", "Croydon", "Darlington", "Dartford",
    "Derby", "Doncaster", "Dorchester", "Dudley", "Durham", "Enfield", "Exeter",
    "Gloucester", "Guernsey", "Guildford", "Halifax", "Harrogate", "Harrow",
    "Hemel Hempstead", "Hereford", "Huddersfield", "Hull", "Ilford", "Ipswich",
    "Isle Of Man", "Kingston Upon Thames", "Lancaster", "Leicester", "Lincoln",
    "Liverpool", "Luton", "Milton Keynes", "Newcastle Upon Tyne", "Northampton",
    "Norwich", "Nottingham", "Oxford", "Peterborough", "Plymouth", "Portsmouth",
    "Preston", "Reading", "Redhill", "Romford", "Salisbury", "Sheffield", "Slough",
    "Southall", "Southampton", "Southend-On-Sea", "St. Albans", "Stevenage",
    "Stoke-On-Trent", "Sunderland", "Sutton", "Swindon", "Taunton", "Telford",
    "Tonbridge", "Torquay", "Truro", "Twickenham", "Wakefield", "Walsall", "Watford",
    "Wolverhampton", "Worcester", "York", "Belfast", "Edinburgh", "Glasgow",
    "Aberdeen", "Dumfries", "Dundee", "Falkirk", "Galashiels", "Inverness",
    "Kilmarnock", "Kirkcaldy", "Motherwell", "Paisley", "Perth", "Cardiff",
    "Llandudno", "Newport", "Shrewsbury", "Swansea"
    
    ]

    for i in cities:
        print(f"Scraping listings for {i}...")
        rooms = scrape_spareroom_rooms(area=i, pages=5)
        export_to_json(rooms, city=i)


    # Optional: Print results (you can remove this if not needed)
    for idx, room in enumerate(rooms, 1):
        print(f"{idx}. {room['Title']}")
        print(f"   Location: {room['Location']}")
        print(f"   Price: {room['Price']}")
        print(f"   Description: {room['Description']}")
        print(f"   Link: {room['Link']}")
        print()
    


