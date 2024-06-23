# WP Post AutoTagger

The **WP Post Auto Tagger** plugin automatically enhances your WordPress posts by adding relevant tags based on synonyms of the post title. This feature helps improve your site's SEO and content discoverability by associating your posts with a broader set of relevant keywords.

## Features
- Automatically adds tags to new posts based on the title.
- Utilizes the Datamuse API to find synonyms of the post title.
- Ensures that tags are only added if the post does not already have tags.
- Includes the post title itself as a tag for better relevance.

## How It Works
1. **Hook into save_post**: The plugin hooks into the `save_post` action to trigger its functionality whenever a post is saved.
2. **Check Conditions**: It first checks if the save action is an autosave or if the post status is "auto-draft" to avoid unnecessary operations.
3. **Fetch Synonyms**: If the post does not already have tags, it retrieves synonyms of the post title using the Datamuse API.
4. **Set Tags**: It then adds these synonyms, along with the post title itself, as tags to the post.

## Technical Details
- **Datamuse API**: The plugin uses the Datamuse API to fetch synonyms for the post title. The API endpoint used is `https://api.datamuse.com/words?rel_syn=`.
- **Error Handling**: The plugin includes basic error handling to ensure that issues with the API do not affect the site's functionality.
