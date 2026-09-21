# Controller boundary

This lightweight application keeps request-page handlers in `public/` and `admin/` for normal shared-hosting compatibility. They delegate validation and business rules to `App\Services\PortfolioService`, which only uses repository interfaces. Add larger controller classes here without changing the database adapters.
