module.exports = {
  'Test restaurant form': (browser) => {
    // load the restaurant page
    browser
      .url(browser.launchUrl + '/restaurant-search')
      .waitForElementVisible('body', 1000);

    // assert an <h1> is present
    browser
      .expect
      .element('h1')
      .to.be.present;

    // assert the <h1> title is as expected
    browser
      .assert
      .containsText(
        'h1',
        'Restaurant Search'
      );

    // check form field available
    browser
      .expect
      .element('input[name="Keyword"]')
      .to.be.present;

    // add text into search form
    browser.setValue('input[name="Keyword"]', 'chicken');

    // submit the form
    browser.submitForm('form#Form_RestaurantForm');

    // wait for results to load
    browser.waitForElementVisible('.results', 3000);

    // validate number of results
    browser.elements(
      'css selector',
      '.results__item',
      (result) => {
        browser.assert.equal(result.value.length, 10)
      }
    );

    // close the browser
    browser.end();
  }
}
