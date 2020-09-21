1) Remove 2 random fields from the Shipping step - there were 3 ways to implement this.
    1 - it's a setting in admin panel for Community and a separated CustomerAttributes module for enterprise, hence I could remove it via data patch;
    2 - unset these fields via LayoutProcessor;
    3 - the most 'FE skills' one - hide these fields via layout, and that's what I did.
2) All other field names, which should be written vice versa, like Name, should be emaN - there were (at least) 2 ways to achieve this:
    1 - rewrite field.html and insert js code instead of element.label (change it to element.label.split('').reverse().join('')), but I didn't want to mix js and html
    2 - add custom action reverseLabel and apply it to labels for fields and group (relevant for street fields)
3) And the next step button should redirect back to the cart.
    1 - I could add new function like 'goToCart'and add it as a click handler for the button
    2 - I could turn this button into <a> and add href="/checkout/cart"
    3 - what I did - rewrite function, which is basically a submit handler, to make it redirect customer to cart

