# Digital Library

> Simple PHP site for browsing and downloading files (e.g. e-books) from a configured folder, with safe `basename()` handling to prevent directory traversal.

## Configuration

In `index.php`, set `$dir` to the folder that holds your downloadable files (default: `book/`). Place files in that directory.

## Requirements

- PHP with a web server (Apache, Nginx, etc.)

## Usage

1. Deploy the project folder to your web host.
2. Add files to the configured `$dir` folder.
3. Open the site in a browser to browse the catalog.
4. Download links are served via `?download=filename`.

## License

MIT — see [LICENSE](LICENSE).  
Copyright © 2026 [MacWeb Canada](https://macweb.ca) | Professional Online Solutions.
