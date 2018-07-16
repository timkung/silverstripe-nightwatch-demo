module.exports = {
  'Test page title': (browser) => {
    // load the home page
    browser
      .url(browser.launchUrl)
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
        'Home'
      );

    // close the browser
    browser.end();
  }
}
