# React Integration for Haliyora Theme

This document explains how to use React components throughout the Haliyora WordPress theme.

## Overview

The Haliyora theme now includes a comprehensive React integration system that allows you to use React components anywhere in your WordPress templates. This provides enhanced interactivity and dynamic content capabilities.

## Included React Components

### 1. MaterialCard
A Material Design-styled card component.

```php
echo haliyora_react_component('MaterialCard', array(
    'title' => 'Card Title',
    'children' => 'Card content goes here'
), array('style' => 'margin-bottom: 20px;'));
```

### 2. MaterialButton
An interactive Material Design button.

```php
echo haliyora_react_component('MaterialButton', array(
    'children' => 'Click Me',
    'variant' => 'contained', // 'contained' or 'outlined'
    'onClick' => 'handleClick' // Will be converted to inline JS
));
```

### 3. DynamicContentLoader
Loads and displays dynamic content from any endpoint.

```php
echo haliyora_react_component('DynamicContentLoader', array(
    'endpoint' => '/wp-json/wp/v2/posts?per_page=5',
    'renderFunction' => 'function(data) { return React.createElement("div", null, data.map(item => React.createElement("div", {key: item.id}, item.title.rendered))); }'
));
```

### 4. CommentSystem
A full-featured comment system built with React.

```php
echo haliyora_react_component('CommentSystem', array(
    'postId' => get_the_ID(),
    'currentUser' => haliyora_get_current_user_data(),
    'enableReplies' => true
));
```

### 5. NewsCarousel
A responsive news carousel component.

```php
echo haliyora_react_component('NewsCarousel', array(
    'posts' => $posts_data, // Array of post objects with id, title, excerpt, etc.
    'autoPlay' => true,
    'interval' => 5000,
    'showArrows' => true,
    'showIndicators' => true
));
```

### 6. SearchComponent
A dynamic search component.

```php
echo haliyora_react_component('SearchComponent', array(
    'placeholder' => 'Search posts...',
    'searchEndpoint' => '/wp-json/wp/v2/posts'
));
```

## How to Use

### 1. In PHP Templates
Use the `haliyora_react_component()` function in your PHP template files:

```php
<?php
echo haliyora_react_component('MaterialCard', array(
    'title' => 'My React Card',
    'children' => 'This content is rendered by React!'
));
?>
```

### 2. Direct HTML Implementation
You can also place React components directly in HTML using data attributes:

```html
<div data-react-component="MaterialCard" data-props='{"title": "Direct Implementation", "children": "Rendered from HTML!"}'></div>
```

### 3. JavaScript Integration
Access React components from JavaScript:

```javascript
// Access components globally
if (window.HaliyoraReact) {
    const root = ReactDOM.createRoot(document.getElementById('my-container'));
    root.render(React.createElement(HaliyoraReact.MaterialCard, {
        title: 'Dynamically Created',
        children: 'Created via JavaScript'
    }));
}
```

## Data Preparation Functions

### haliyora_get_current_user_data()
Gets current user data for use in React components.

### haliyora_get_rest_api_base()
Gets the WordPress REST API base URL.

### haliyora_get_site_info()
Gets general site information.

## Available Templates

- `page-react-demo.php` - A demonstration page showing various React components
- `page-trending-react.php` - The trending page with React integration
- `index-react-enhanced.php` - Home page with React components

## Best Practices

1. **Performance**: Only use React components where needed; don't over-engineer simple UI elements.
2. **SEO**: Consider server-side rendering for content that needs to be indexed by search engines.
3. **Progressive Enhancement**: Ensure the site works without JavaScript as a baseline.
4. **Data Preparation**: Prepare data in PHP before passing to React components for better performance.

## Troubleshooting

If React components aren't rendering:

1. Check that React and ReactDOM are loaded (inspect page source)
2. Verify the component name is correct
3. Check browser console for JavaScript errors
4. Ensure data attributes are properly formatted

## Custom Components

To create your own React components:

1. Add them to the `HaliyoraReactComponents` object in `/js/react-integration.js`
2. Register them in the `renderReactComponents` function
3. Use them with `haliyora_react_component()` function in PHP

## Dependencies

- React 18 (production build)
- React DOM 18 (production build)
- Babel Standalone (for JSX transformation in development)

All dependencies are loaded from CDN for optimal performance.