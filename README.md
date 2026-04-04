# Digital library (PHP)

Simple PHP site for browsing and **downloading files** (for example e-books) from a configured folder. Downloads are served with safe `basename()` handling to avoid directory traversal.

## Configuration

In `index.php`, set `$dir` to the folder that holds your files (default `book/`). Put downloadable files in that directory.

## Requirements

- PHP with a web server (Apache, nginx, etc.).

## Usage

Open the site in a browser to browse the catalog. Download links use `?download=filename`.

## License

See [LICENSE](LICENSE) (MIT).
