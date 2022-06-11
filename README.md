# Google Ads Markdown Placement Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of the plugin.**

The **Google Ads Markdown Placement** Plugin is an extension for [Grav CMS](http://github.com/getgrav/grav). Add google ads inside the markdown rendering

## Installation

Installing the Google Ads Markdown Placement plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install google-ads-markdown-placement

This will install the Google Ads Markdown Placement plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/google-ads-markdown-placement`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `google-ads-markdown-placement`. You can find these files on [GitHub](https://github.com/dennisdebest/grav-plugin-google-ads-markdown-placement) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/google-ads-markdown-placement
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/dennisdebest/grav-plugin-google-ads-markdown-placement/blob/master/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/google-ads-markdown-placement/google-ads-markdown-placement.yaml` to `user/config/plugins/google-ads-markdown-placement.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
ad_client:
ad_slot:
ad_format: auto
ad_class:
```

Note that if you use the Admin Plugin, a file with your configuration named google-ads-markdown-placement.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

**This plugin is here to make it easy to add Google Ads in the middle of your markdown.**

When adding `<g-ad/>` anywhere in your markdown code this will get replaced by the rendering of a Google Ad based on the configuration settings.

If you have not set the default settings for the **ad_client** nothing will be rendered.

You can override these settings for every tag that you render :

```markdown
> this is my markdown file

Look at this ad

<g-ad [adClient=my-other-ad-client adSlot=1234596 adFormat=auto adClass=customClass]/>

there it is with my **customClass**
```

## To Do

- [ ] Only inject the Google JavaScript once
- [ ] Add more customisation options

