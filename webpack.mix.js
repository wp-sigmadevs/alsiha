/**
 * Laravel Mix Configuration File.
 */

const mix = require("laravel-mix");
const fs = require("fs-extra");
const path = require("path");
const cliColor = require("cli-color");
const emojic = require("emojic");
const wpPot = require("wp-pot");
const archiver = require("archiver");

const package_path = path.resolve(__dirname);
const package_slug = path.basename(path.resolve(package_path));
const temDirectory = package_path + "/dist";

mix.options({
	terser: {
		extractComments: false,
	},
	processCssUrls: false,
});

// mix.webpackConfig({
// 	stats: {
// 		children: true,
// 	},
// });

if (process.env.npm_config_package) {
	mix.then(function () {
		const copyTo = path.resolve(`${temDirectory}/${package_slug}`);

		// Select All file then paste on list
		let includes = [
			"assets",
			"framework",
			"languages",
			"lib",
			"page-templates",
			"templates",
			"vendor",
			"404.php",
			"archive.php",
			"comments.php",
			"footer.php",
			"functions.php",
			"header.php",
			"index.php",
			"page.php",
			"screenshot.png",
			"search.php",
			"sidebar.php",
			"single.php",
			"style.css",
		];

		fs.ensureDir(copyTo, function (err) {
			if (err) return console.error(err);
			includes.map((include) => {
				fs.copy(
					`${package_path}/${include}`,
					`${copyTo}/${include}`,
					function (err) {
						if (err) return console.error(err);
						console.log(
							cliColor.white(`=> ${emojic.smiley}  ${include} copied...`)
						);
					}
				);
			});

			console.log(
				cliColor.white(`=> ${emojic.whiteCheckMark}  Build directory created`)
			);
		});
	});

	return;
}

if (
	!process.env.npm_config_block &&
	!process.env.npm_config_package &&
	(process.env.NODE_ENV === "development" ||
		process.env.NODE_ENV === "production")
) {
	if (mix.inProduction()) {
		let languages = path.resolve("languages");
		fs.ensureDir(languages, function (err) {
			if (err) return console.error(err); // if file or folder does not exist
			wpPot({
				package: "Al-Siha WordPress Theme",
				bugReport: "https://github.com/wp-sigmadevs/alsiha/issues",
				src: "**/*.php",
				domain: "alsiha",
				destFile: "languages/alsiha.pot",
			});
		});
	}

	/**
	 * JS
	 */
	mix
		// Backend JS
		.js('src/js/backend/backend.js', 'assets/js/backend/backend.min.js')
		.js('src/js/backend/customize-preview.js', 'assets/js/backend/customize-preview.min.js')

		// Frontend JS
		.js("src/js/frontend/frontend.js", "assets/js/frontend/frontend.min.js")

	/**
	 * CSS
	 */
	mix
		// Backend CSS
		.sass('src/sass/backend/customizer.scss', 'assets/css/backend/customizer.min.css')
		.sass('src/sass/backend/editor-style.scss', 'assets/css/backend/editor-style.min.css')
		.sass('src/sass/backend/elementor-editor.scss', 'assets/css/backend/elementor-editor.min.js')
		.sass('src/sass/backend/elementor-editor-style-fix.scss', 'assets/css/backend/elementor-editor-style-fix.min.css')

	if (!mix.inProduction()) {
		mix.sass("src/sass/frontend/frontend.scss", "assets/css/frontend/frontend.css").sourceMaps(true, 'source-map');
		mix.sass("src/sass/frontend/frontend-rtl.scss", "assets/css/rtl/frontend-rtl.css").sourceMaps(true, 'source-map');

		mix.postCss('assets/css/frontend/frontend.min.css', 'assets/css/rtl/compiled-rtl.css', [
			require('rtlcss'),
		]);
		mix.combine([
			'assets/css/rtl/compiled-rtl.css',
			'assets/css/rtl/frontend-rtl.css'
		], 'assets/css/frontend/frontend-rtl.css');
	} else {
		mix.sass("src/sass/frontend/frontend.scss", "assets/css/frontend/frontend.min.css");
		mix.sass("src/sass/frontend/frontend-rtl.scss", "assets/css/rtl/frontend-rtl.min.css");

		mix.postCss('assets/css/frontend/frontend.min.css', 'assets/css/rtl/compiled-rtl.css', [
			require('rtlcss'),
		]);
		mix.combine([
			'assets/css/rtl/compiled-rtl.css',
			'assets/css/rtl/frontend-rtl.min.css'
		], 'assets/css/frontend/frontend-rtl.min.css');
	}
}
if (process.env.npm_config_zip) {
	async function getVersion() {
		let data;
		try {
			data = await fs.readFile(package_path + `/style.css`, "utf-8");
		} catch (err) {
			console.error(err);
		}
		const lines = data.split(/\r?\n/);
		let version = "";
		for (let i = 0; i < lines.length; i++) {
			if (lines[i].includes("* Version:") || lines[i].includes("Version:")) {
				version = lines[i]
					.replace("Version:", "")
					.trim();
				break;
			}
		}
		return version;
	}

	const version_get = getVersion();
	version_get.then(function (version) {
		const destinationPath = `${temDirectory}/${package_slug}.${version}.zip`;
		const output = fs.createWriteStream(destinationPath);
		const archive = archiver("zip", { zlib: { level: 9 } });
		output.on("close", function () {
			console.log(archive.pointer() + " total bytes");
			console.log(
				"Archive has been finalized and the output file descriptor has closed."
			);
			fs.removeSync(`${temDirectory}/${package_slug}`);
		});
		output.on("end", function () {
			console.log("Data has been drained");
		});
		archive.on("error", function (err) {
			throw err;
		});

		archive.pipe(output);
		archive.directory(`${temDirectory}/${package_slug}`, package_slug);
		archive.finalize();
	});
}
