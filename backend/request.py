from playwright.sync_api import sync_playwright
import re
import csv
import json

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

def scrape_spareroom_rooms():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        url = 'https://www.spareroom.co.uk/flatshare/?search_id=1354370850&'
        page.goto(url, timeout=60000)
        page.wait_for_selector('.listing-result', timeout=10000)

        listings = page.query_selector_all('.listing-result')
        results = []

        print(f"Found {len(listings)} listings")

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
                print(f"Error processing listing: {e}")
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

def export_to_json(data, filename='spareroom_listings.json'):
    with open(filename, 'w', encoding='utf-8') as jsonfile:
        json.dump(data, jsonfile, ensure_ascii=False, indent=4)
    print(f"✅ Data exported to {filename}")

# Example usage
if __name__ == "__main__":
    rooms = scrape_spareroom_rooms()

    for idx, room in enumerate(rooms, 1):
        print(f"{idx}. {room['Title']}")
        print(f"   Location: {room['Location']}")
        print(f"   Price: {room['Price']}")
        print(f"   Description: {room['Description']}")
        print(f"   Link: {room['Link']}")
        print()

    export_to_csv(rooms)
    export_to_json(rooms)
