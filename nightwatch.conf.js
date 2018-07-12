const seleniumServer = require('selenium-server');
const chromedriver = require('chromedriver');

module.exports = (function(settings) {
  settings.selenium.server_path = seleniumServer.path;
  settings.selenium.cli_args['webdriver.chrome.driver'] = chromedriver.path;

  // set optional --url cli arg
  let urlIndex = process.argv.indexOf('--url');
  if (urlIndex > -1) {
    settings.test_settings.default.launch_url = process.argv[urlIndex + 1];
  }

  return settings;
})(require('./nightwatch.json'));